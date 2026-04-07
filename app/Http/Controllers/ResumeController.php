<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResumeController extends Controller
{
    use AuthorizesRequests;
    public function create(): View
    {
        return view('resumes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'full_name'       => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'nullable|string|max:50',
            'location'        => 'nullable|string|max:255',
            'summary'         => 'nullable|string',
            'work_experience' => 'nullable|array',
            'education'       => 'nullable|array',
            'skills'          => 'nullable|array',
        ]);

        $resume = $request->user()->resumes()->create($validated);

        return redirect()->route('resumes.show', $resume)->with('success', 'Resume created.');
    }

    public function show(Resume $resume): View
    {
        $this->authorize('view', $resume);

        return view('resumes.show', compact('resume'));
    }

    public function edit(Resume $resume): View
    {
        $this->authorize('update', $resume);

        return view('resumes.edit', compact('resume'));
    }

    public function update(Request $request, Resume $resume): RedirectResponse
    {
        $this->authorize('update', $resume);

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'full_name'       => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'nullable|string|max:50',
            'location'        => 'nullable|string|max:255',
            'summary'         => 'nullable|string',
            'work_experience' => 'nullable|array',
            'education'       => 'nullable|array',
            'skills'          => 'nullable|array',
        ]);

        $resume->update($validated);

        return redirect()->route('resumes.show', $resume)->with('success', 'Resume updated.');
    }

    public function destroy(Resume $resume): RedirectResponse
    {
        $this->authorize('delete', $resume);

        $resume->delete();

        return redirect()->route('dashboard')->with('success', 'Resume deleted.');
    }
}
