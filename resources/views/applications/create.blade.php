<x-app-layout>
    <div class="max-w-2xl mx-auto px-6 py-12">

        {{-- Page header --}}
        <div class="mb-10">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-[#555] hover:text-[#f0ece4] transition mb-5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Dashboard
            </a>
            <h1 class="font-heading text-5xl text-[#f0ece4] leading-none">
                TAILOR WITH <span class="text-volt">AI</span>
            </h1>
            <p class="mt-3 text-sm text-[#555]">Paste a job description and Claude will rewrite your resume to match — then write you a cover letter.</p>
        </div>

        @if ($resumes->isEmpty())
            <div class="border border-dashed border-[#1f1f1f] rounded-xl p-12 text-center">
                <div class="w-12 h-12 bg-[#111] border border-[#1f1f1f] rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-5 h-5 text-[#444]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-[#555] text-sm mb-5">You need a resume before you can tailor an application.</p>
                <a href="{{ route('resumes.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                    Build a Resume First
                </a>
            </div>
        @else
            <form method="POST" action="{{ route('applications.store') }}" class="space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="flex items-start gap-3 bg-[#1a0000] border border-[#330000] text-[#ff5555] rounded-xl px-5 py-4 text-sm">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <ul class="space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Resume selector --}}
                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-[#1a1a1a]">
                        <span class="text-xs font-mono text-volt">01</span>
                        <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Select Base Resume</h2>
                    </div>
                    <div class="p-6">
                        <select name="resume_id"
                            class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition appearance-none cursor-pointer" required>
                            <option value="" class="bg-[#111]">Choose a resume…</option>
                            @foreach ($resumes as $resume)
                                <option value="{{ $resume->id }}" class="bg-[#111]"
                                    {{ old('resume_id', request('resume_id')) == $resume->id ? 'selected' : '' }}>
                                    {{ $resume->title }} — {{ $resume->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Job details --}}
                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-[#1a1a1a]">
                        <span class="text-xs font-mono text-volt">02</span>
                        <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Job Details</h2>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">
                                Job Title <span class="text-volt">*</span>
                            </label>
                            <input type="text" name="job_title" value="{{ old('job_title') }}" placeholder="e.g. Senior Software Engineer"
                                class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">
                                Company <span class="text-volt">*</span>
                            </label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="e.g. Acme Corp"
                                class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition" required>
                        </div>
                    </div>
                </div>

                {{-- Job description --}}
                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-[#1a1a1a]">
                        <span class="text-xs font-mono text-volt">03</span>
                        <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Job Description</h2>
                    </div>
                    <div class="p-6">
                        <textarea name="job_description" rows="14"
                            placeholder="Paste the full job posting here. The more detail you provide, the better Claude can tailor your resume…"
                            class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition resize-none leading-relaxed" required>{{ old('job_description') }}</textarea>
                        <p class="mt-2 text-xs text-[#444]">Paste the complete job posting for best results.</p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-4 pt-2">
                    <a href="{{ route('dashboard') }}" class="text-sm text-[#555] hover:text-[#f0ece4] transition">Cancel</a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Tailor My Resume
                    </button>
                </div>
            </form>
        @endif
    </div>
</x-app-layout>
