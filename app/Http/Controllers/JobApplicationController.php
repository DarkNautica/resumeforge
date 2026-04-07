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

            // Strip accidental markdown code fences if Claude wraps the response
            $rawText = preg_replace('/^```(?:json)?\s*/i', '', trim($rawText));
            $rawText = preg_replace('/\s*```$/', '', $rawText);

            $parsed = json_decode(trim($rawText), true);

            $application->update([
                'tailored_resume' => $parsed['tailored_resume'],
                'cover_letter'    => $parsed['cover_letter'],
                'status'          => 'complete',
            ]);

            // Deduct one credit for pay-per-use users
            if (! $request->user()->isSubscribed()) {
                $request->user()->decrement('tailor_credits');
            }
        } catch (\Throwable $e) {
            \Log::error('TailorAI generation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
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

    public function downloadPdf(Request $request, JobApplication $application): Response
    {
        $this->authorize('view', $application);

        abort_if(empty($application->tailored_resume), 404, 'No tailored resume available.');

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

        $pdf = Pdf::loadView("pdf.{$template}", compact('application'))
            ->setPaper('a4', 'portrait');

        $name     = $application->tailored_resume['full_name'] ?? 'resume';
        $company  = $application->company_name;
        $filename = Str::slug("{$name} {$company} {$template} resume") . '.pdf';

        return $pdf->download($filename);
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
            if (! is_string($rawText)) {
                return $fallback;
            }

            // Strip accidental markdown code fences
            $rawText = preg_replace('/^```(?:json)?\s*/i', '', trim($rawText));
            $rawText = preg_replace('/\s*```$/', '', $rawText);

            $parsed = json_decode(trim($rawText), true);

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
