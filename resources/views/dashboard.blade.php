<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-12 space-y-12">

        {{-- ─── Onboarding prompt ───────────────────────────────── --}}
        @if ($resumes->isEmpty())
            <div class="bg-[#0d1a00] border border-[#C8FF00]/20 rounded-2xl p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="min-w-0">
                    <div class="text-[#C8FF00] text-xs font-bold uppercase tracking-widest mb-2">Get Started</div>
                    <h2 class="font-['Bebas_Neue'] text-3xl text-white mb-2 leading-none">CREATE YOUR BASE RESUME</h2>
                    <p class="text-[#888] text-sm">Build your resume once, tailor it to every job in seconds.</p>
                </div>
                <a href="{{ route('resumes.create') }}"
                    class="bg-[#C8FF00] text-black font-bold px-8 py-4 rounded-xl hover:bg-[#d4ff00] transition whitespace-nowrap shrink-0">
                    Create Resume →
                </a>
            </div>
        @elseif ($applications->isEmpty())
            <div class="bg-[#0a0a1a] border border-[#4f46e5]/30 rounded-2xl p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="min-w-0">
                    <div class="text-[#818cf8] text-xs font-bold uppercase tracking-widest mb-2">Next Step</div>
                    <h2 class="font-['Bebas_Neue'] text-3xl text-white mb-2 leading-none">TAILOR YOUR FIRST RESUME</h2>
                    <p class="text-[#888] text-sm">Paste a job description and watch AI transform your resume in seconds.</p>
                </div>
                <a href="{{ route('applications.create') }}"
                    class="bg-[#4f46e5] text-white font-bold px-8 py-4 rounded-xl hover:bg-[#4338ca] transition whitespace-nowrap shrink-0">
                    Tailor Resume →
                </a>
            </div>
        @endif

        {{-- Page header --}}
        <div class="flex items-end justify-between">
            <div>
                <p class="text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Overview</p>
                <h1 class="font-heading text-5xl text-[#f0ece4] leading-none">
                    YOUR <span class="text-volt">WORKSPACE</span>
                </h1>
            </div>
            <div class="flex items-center gap-3">
                {{-- Access status badge --}}
                @if (auth()->user()->isSubscribed())
                    <a href="{{ route('plans') }}"
                        class="px-3 py-1.5 bg-[#0d2600] border border-[#1a4a00] text-volt text-xs font-semibold rounded-lg">
                        Unlimited
                    </a>
                @else
                    <a href="{{ route('plans') }}"
                        class="px-3 py-1.5 bg-[#111] border border-[#1f1f1f] text-[#555] text-xs font-medium rounded-lg hover:border-volt hover:text-volt transition">
                        {{ auth()->user()->tailor_credits }} credit{{ auth()->user()->tailor_credits !== 1 ? 's' : '' }}
                    </a>
                @endif
                <a href="{{ route('resumes.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Resume
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="flex items-center gap-3 bg-[#0d2600] border border-[#1a4a00] text-volt rounded-xl px-5 py-3.5 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Resumes section --}}
        <section>
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <h2 class="text-sm font-semibold text-[#f0ece4] uppercase tracking-widest">My Resumes</h2>
                    @if ($resumes->isNotEmpty())
                        <span class="px-2 py-0.5 bg-[#111] border border-[#1f1f1f] text-[#555] text-xs rounded-md">
                            {{ $resumes->count() }}
                        </span>
                    @endif
                </div>
            </div>

            @if ($resumes->isEmpty())
                <div class="border border-dashed border-[#1f1f1f] rounded-xl p-12 text-center">
                    <div class="w-12 h-12 bg-[#111] border border-[#1f1f1f] rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-5 h-5 text-[#444]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-[#555] text-sm mb-5">No resumes yet. Build your base resume to get started.</p>
                    <a href="{{ route('resumes.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                        Build your resume
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($resumes as $resume)
                        <div class="group bg-[#111] border border-[#1f1f1f] rounded-xl p-5 flex flex-col gap-4 hover:border-[#2a2a2a] transition">
                            <div class="w-8 h-0.5 bg-volt rounded-full"></div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-[#f0ece4] truncate">{{ $resume->title }}</h4>
                                <p class="text-sm text-[#666] mt-1">{{ $resume->full_name }}</p>
                                @if ($resume->location)
                                    <p class="text-xs text-[#444] mt-0.5">{{ $resume->location }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-4 text-sm border-t border-[#1a1a1a] pt-4">
                                <a href="{{ route('resumes.show', $resume) }}"
                                    class="text-[#555] hover:text-[#f0ece4] transition">View</a>
                                <a href="{{ route('resumes.edit', $resume) }}"
                                    class="text-[#555] hover:text-[#f0ece4] transition">Edit</a>
                                <a href="{{ route('applications.create', ['resume_id' => $resume->id]) }}"
                                    class="ml-auto text-volt text-sm font-medium group-hover:underline">
                                    Tailor →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- Applications section --}}
        <section>
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <h2 class="text-sm font-semibold text-[#f0ece4] uppercase tracking-widest">Recent Applications</h2>
                    @if ($applications->isNotEmpty())
                        <span class="px-2 py-0.5 bg-[#111] border border-[#1f1f1f] text-[#555] text-xs rounded-md">
                            {{ $applications->count() }}
                        </span>
                    @endif
                </div>
                @if ($resumes->isNotEmpty())
                    <a href="{{ route('applications.create') }}" class="text-sm text-volt hover:underline">
                        New application →
                    </a>
                @endif
            </div>

            @if ($applications->isEmpty())
                <div class="border border-dashed border-[#1f1f1f] rounded-xl p-12 text-center">
                    <div class="w-12 h-12 bg-[#111] border border-[#1f1f1f] rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-5 h-5 text-[#444]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <p class="text-[#555] text-sm">
                        No applications yet. Select a resume and paste a job description to tailor it with AI.
                    </p>
                </div>
            @else
                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                    @foreach ($applications as $app)
                        @php
                            $badgeClass = match($app->status) {
                                'complete'   => 'bg-[#0d2600] text-volt border border-[#1a4a00]',
                                'processing' => 'bg-[#1a1400] text-[#ffcc00] border border-[#332800]',
                                'failed'     => 'bg-[#1a0000] text-[#ff5555] border border-[#330000]',
                                default      => 'bg-[#111] text-[#555] border border-[#2a2a2a]',
                            };
                        @endphp
                        <div class="flex items-center justify-between px-5 py-4 {{ !$loop->last ? 'border-b border-[#1a1a1a]' : '' }} hover:bg-[#141414] transition opacity-0 translate-y-4"
                             x-data x-init="setTimeout(() => { $el.classList.add('opacity-100', 'translate-y-0'); $el.classList.remove('opacity-0', 'translate-y-4'); }, {{ $loop->index * 100 }})"
                             style="transition: opacity 0.5s ease, transform 0.5s ease;">
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-[#f0ece4] truncate">
                                    {{ $app->job_title }}
                                    <span class="text-[#555] font-normal">at {{ $app->company_name }}</span>
                                </p>
                                <p class="text-xs text-[#444] mt-0.5">
                                    {{ $app->resume->title ?? '—' }} &middot; {{ $app->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex items-center gap-4 ml-4 shrink-0">
                                <span class="inline-block px-2.5 py-0.5 rounded-md text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                                <a href="{{ route('applications.show', $app) }}"
                                    class="text-sm text-volt hover:underline">View →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>
</x-app-layout>
