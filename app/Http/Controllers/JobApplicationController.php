<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class JobApplicationController extends Controller
{
    use AuthorizesRequests;
    public function create(Request $request): View
    {
        $resumes = $request->user()->resumes()->orderByDesc('created_at')->get();

        return view('applications.create', compact('resumes'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Rate limit: max 20 tailors per hour per user
        if (RateLimiter::tooManyAttempts('tailor:' . auth()->id(), 20)) {
            return back()->withErrors([
                'error' => 'You have run too many tailors this hour. Please wait before trying again.',
            ])->withInput();
        }
        RateLimiter::hit('tailor:' . auth()->id(), 3600);

        // Paywall: require active subscription or at least one credit
        if (! $request->user()->hasAccess()) {
            return redirect()->route('plans')
                ->with('warning', 'You need credits to tailor a resume.');
        }

        $validated = $request->validate([
            'resume_id'       => 'required|exists:resumes,id',
            'job_title'       => 'required|string|max:100',
            'company_name'    => 'required|string|max:100',
            'job_description' => 'required|string|max:8000',
        ], [
            'job_title.max'       => 'Job title may not exceed 100 characters.',
            'company_name.max'    => 'Company name may not exceed 100 characters.',
            'job_description.max' => 'Job description may not exceed 8,000 characters. Try trimming the posting to the key requirements.',
        ]);

        // Ensure the selected resume belongs to the authenticated user
        $resume = $request->user()->resumes()->findOrFail($validated['resume_id']);

        $application = $request->user()->jobApplications()->create([
            'resume_id'       => $resume->id,
            'job_title'       => $validated['job_title'],
            'company_name'    => $validated['company_name'],
            'job_description' => $validated['job_description'],
            'status'          => 'processing',
        ]);

        // ─── Score the ORIGINAL base resume against the job (before tailoring) ──
        // Fully isolated: any failure here (API error, DB column missing, etc.) MUST NOT
        // block the main generation. If this throws, we just skip the original score.
        try {
            $originalScoreData = $this->scoreResumeAgainstJob(
                $resume->only(['full_name', 'summary', 'work_experience', 'education', 'skills']),
                $validated['job_description']
            );
            if ($originalScoreData) {
                $application->update(['original_score' => $originalScoreData['score']]);
            }
        } catch (\Throwable $e) {
            \Log::warning('Original score skipped: ' . $e->getMessage());
        }

        try {
            $systemPrompt = <<<PROMPT
You are an expert resume writer and career coach. Your job is to tailor a candidate's resume specifically for a job posting and write a matching cover letter.

You will be given:
1. The candidate's base resume as structured JSON
2. The job title, company name, and full job description

Your task:
- Rewrite the resume summary, work experience descriptions, and skills list to highlight what is most relevant for this specific role. Preserve all factual information (dates, company names, job titles, degrees) — only rewrite descriptive text.
- Write a professional, personalized cover letter (3–4 paragraphs) addressed to the company.

Respond with ONLY a valid JSON object — no markdown, no code fences, no extra text. The object must have exactly these two keys:
{
  "tailored_resume": {
    "full_name": "...",
    "email": "...",
    "phone": "...",
    "location": "...",
    "summary": "...",
    "work_experience": [
      { "title": "...", "company": "...", "start_date": "...", "end_date": "...", "description": "..." }
    ],
    "education": [
      { "degree": "...", "institution": "...", "year": "..." }
    ],
    "skills": ["...", "..."]
  },
  "cover_letter": "Full cover letter text here..."
}
PROMPT;

            $userMessage = sprintf(
                "Job Title: %s\nCompany: %s\n\nJob Description:\n%s\n\nCandidate's Base Resume (JSON):\n%s",
                $application->job_title,
                $application->company_name,
                $application->job_description,
                json_encode($resume->only([
                    'full_name', 'email', 'phone', 'location',
                    'summary', 'work_experience', 'education', 'skills',
                ]), JSON_PRETTY_PRINT)
            );

            $response = Http::withHeaders([
                'x-api-key'         => config('services.anthropic.key'),
                'anthropic-version' => '2023-06-01',
                'content-type'      => 'application/json',
            ])->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-sonnet-4-6',
                'max_tokens' => 4000,
                'system'     => $systemPrompt,
                'messages'   => [
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

            \Log::info('Claude raw response', ['status' => $response->status(), 'body' => $response->json()]);

            $rawText = $response->json('content.0.text');

            \Log::info('Claude content.0.text', ['value' => $rawText]);

            // Strip markdown code fences before parsing
            $rawText = preg_replace('/^```(?:json)?\s*|\s*```$/s', '', trim($rawText));

            $parsed = $this->extractJsonObject($rawText);

            // Guard: if Claude returned malformed JSON, surface a useful error
            if (! is_array($parsed) || ! isset($parsed['tailored_resume'], $parsed['cover_letter'])) {
                throw new \RuntimeException(
                    'Claude returned malformed JSON. HTTP ' . $response->status()
                    . ' · Body preview: ' . substr((string) $rawText, 0, 300)
                );
            }

            $application->update([
                'tailored_resume' => $parsed['tailored_resume'],
                'cover_letter'    => $parsed['cover_letter'],
                'status'          => 'complete',
            ]);

            // ─── Score the TAILORED resume against the job ──
            // Isolated so a scoring failure never breaks the completed application.
            try {
                $tailoredScoreData = $this->scoreResumeAgainstJob(
                    $parsed['tailored_resume'],
                    $validated['job_description']
                );
                if ($tailoredScoreData) {
                    $application->update([
                        'match_score' => $tailoredScoreData['score'],
                        'match_label' => $tailoredScoreData['label'] ?? null,
                    ]);
                }
            } catch (\Throwable $e) {
                \Log::warning('Tailored score skipped: ' . $e->getMessage());
            }

            // Deduct one credit for pay-per-use users
            if (! $request->user()->isSubscribed()) {
                $request->user()->decrement('tailor_credits');
            }
        } catch (\Throwable $e) {
            \Log::error('TailorAI generation failed: ' . $e->getMessage(), [
                'application_id' => $application->id,
                'user_id'        => $request->user()->id,
                'file'           => $e->getFile() . ':' . $e->getLine(),
                'trace'          => $e->getTraceAsString(),
            ]);
            $application->update(['status' => 'failed']);
        }

        return redirect()->route('applications.show', $application);
    }

    public function show(JobApplication $application): View
    {
        $this->authorize('view', $application);

        $application->load('resume');

        return view('applications.show', compact('application'));
    }

    public function downloadPdf(Request $request, JobApplication $application): \Symfony\Component\HttpFoundation\StreamedResponse|Response
    {
        $this->authorize('view', $application);

        abort_if(empty($application->tailored_resume), 404, 'No tailored resume available.');

        // Eager-load the base resume relationship for the templates
        $application->load('resume');

        // Pick template (executive | modern | classic), default executive
        $allowed  = ['executive', 'modern', 'classic'];
        $template = in_array($request->query('template'), $allowed, true)
            ? $request->query('template')
            : 'executive';

        // Run a quality-check pass through Claude before rendering. Falls back
        // to the stored data silently if anything goes wrong.
        $cleaned = $this->qualityCheck(
            $application->tailored_resume,
            $application->cover_letter ?? ''
        );

        // Apply cleaned data to the in-memory model only — never persisted.
        $application->tailored_resume = $cleaned['tailored_resume'];
        $application->cover_letter    = $cleaned['cover_letter'];

        // Templates expect: $application, $resume (cleaned tailored array), $coverLetter (cleaned string)
        $resume      = $cleaned['tailored_resume'];
        $coverLetter = $cleaned['cover_letter'];

        $pdf = Pdf::loadView("pdf.{$template}", compact('application', 'resume', 'coverLetter'))
            ->setPaper('a4', 'portrait');

        $name    = $resume['full_name'] ?? 'resume';
        $company = $application->company_name;

        // Build a strictly safe filename: slug + only [A-Za-z0-9._-]
        $filename = Str::slug("{$name} {$company} {$template} resume") . '.pdf';
        $filename = preg_replace('/[^A-Za-z0-9._-]/', '', $filename);
        $filename = $filename ?: 'tailored-resume.pdf';

        // Stream with explicit safe headers so browsers don't flag it
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type'           => 'application/pdf',
            'Content-Disposition'    => 'attachment; filename="' . $filename . '"',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control'          => 'private, no-cache',
        ]);
    }

    /**
     * Robustly extract a JSON object from a Claude response that may contain
     * leading prose, trailing prose, and/or markdown code fences.
     * Returns the decoded array or null if no valid JSON object can be parsed.
     */
    private function extractJsonObject(?string $text): ?array
    {
        if (! is_string($text) || trim($text) === '') {
            return null;
        }

        // 1) Try a fenced ```json ... ``` block first (most common case)
        if (preg_match('/```(?:json)?\s*(\{.*?\})\s*```/s', $text, $m)) {
            $decoded = json_decode($m[1], true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        // 2) Fallback: greedy match from the first { to the last } in the string
        $start = strpos($text, '{');
        $end   = strrpos($text, '}');
        if ($start !== false && $end !== false && $end > $start) {
            $candidate = substr($text, $start, $end - $start + 1);
            $decoded = json_decode($candidate, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        // 3) Last resort: try the whole string as-is
        $decoded = json_decode(trim($text), true);
        return is_array($decoded) ? $decoded : null;
    }

    /**
     * Score a resume against a job description using Claude Haiku.
     * Returns ['score' => int 1-100, 'label' => string|null] or null on failure.
     * Non-fatal — caller can ignore null.
     */
    private function scoreResumeAgainstJob(array $resumeData, string $jobDescription): ?array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key'         => config('services.anthropic.key'),
                'anthropic-version' => '2023-06-01',
                'content-type'      => 'application/json',
            ])->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-haiku-4-5-20251001',
                'max_tokens' => 100,
                'messages'   => [[
                    'role'    => 'user',
                    'content' => 'Rate how well this resume matches this job description from 1-100. Return only a JSON object like {"score": 87, "label": "Strong Match"}. Resume: '
                        . json_encode($resumeData)
                        . ' Job: '
                        . substr($jobDescription, 0, 500),
                ]],
            ]);

            $raw = $response->json('content.0.text');
            $clean = preg_replace('/^```(?:json)?\s*|\s*```$/s', '', trim($raw));
            $data = $this->extractJsonObject($clean);

            if (! is_array($data) || ! isset($data['score'])) {
                return null;
            }

            return [
                'score' => max(1, min(100, (int) $data['score'])),
                'label' => $data['label'] ?? null,
            ];
        } catch (\Throwable $e) {
            \Log::warning('Match score generation failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Run a Claude polish pass on the stored resume + cover letter.
     * Returns the cleaned version, or the original input on any failure.
     */
    private function qualityCheck(array $tailoredResume, string $coverLetter): array
    {
        $fallback = [
            'tailored_resume' => $tailoredResume,
            'cover_letter'    => $coverLetter,
        ];

        try {
            $systemPrompt = 'You are a professional resume editor. Review this resume and cover letter for any formatting issues, awkward phrasing, or inconsistencies. Return a corrected version as a JSON object with keys tailored_resume (same structure as input) and cover_letter (cleaned text). Make only necessary improvements, do not change factual content.';

            $userMessage = json_encode([
                'tailored_resume' => $tailoredResume,
                'cover_letter'    => $coverLetter,
            ], JSON_PRETTY_PRINT);

            $response = Http::withHeaders([
                'x-api-key'         => config('services.anthropic.key'),
                'anthropic-version' => '2023-06-01',
                'content-type'      => 'application/json',
            ])->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-sonnet-4-6',
                'max_tokens' => 4000,
                'system'     => $systemPrompt,
                'messages'   => [
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

            if (! $response->successful()) {
                return $fallback;
            }

            $rawText = $response->json('content.0.text');
            $parsed  = $this->extractJsonObject($rawText);

            if (! is_array($parsed)
                || ! isset($parsed['tailored_resume'], $parsed['cover_letter'])
                || ! is_array($parsed['tailored_resume'])
                || ! is_string($parsed['cover_letter'])
            ) {
                return $fallback;
            }

            return $parsed;
        } catch (\Throwable $e) {
            \Log::warning('PDF quality check failed, using stored data', ['error' => $e->getMessage()]);
            return $fallback;
        }
    }
}
