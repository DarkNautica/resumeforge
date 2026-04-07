<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

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
            'job_title'       => 'required|string|max:255',
            'company_name'    => 'required|string|max:255',
            'job_description' => 'required|string',
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
}
