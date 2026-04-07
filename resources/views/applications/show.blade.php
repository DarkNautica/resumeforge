<x-app-layout>
    <div class="max-w-5xl mx-auto px-6 py-12 space-y-8">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-6">
            <div class="min-w-0">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-[#555] hover:text-[#f0ece4] transition mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Dashboard
                </a>
                <h1 class="font-heading text-4xl text-[#f0ece4] leading-none truncate">
                    {{ strtoupper($application->job_title) }}
                </h1>
                <p class="mt-2 text-sm text-[#555]">
                    {{ $application->company_name }}
                    @if ($application->resume)
                        <span class="text-[#333]">&middot;</span>
                        <span class="text-[#444]">{{ $application->resume->title }}</span>
                    @endif
                </p>
            </div>
            <div class="shrink-0 pt-9">
                @php
                    $badgeClass = match($application->status) {
                        'complete'   => 'bg-[#0d2600] text-volt border border-[#1a4a00]',
                        'processing' => 'bg-[#1a1400] text-[#ffcc00] border border-[#332800]',
                        'failed'     => 'bg-[#1a0000] text-[#ff5555] border border-[#330000]',
                        default      => 'bg-[#111] text-[#555] border border-[#2a2a2a]',
                    };
                @endphp
                <span class="inline-block px-3 py-1 rounded-lg text-xs font-semibold {{ $badgeClass }}">
                    {{ ucfirst($application->status) }}
                </span>
            </div>
        </div>

        {{-- Status states --}}
        @if ($application->status === 'pending' || $application->status === 'processing')
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-10 text-center">
                <div class="w-12 h-12 bg-[#1a1400] border border-[#332800] rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-5 h-5 text-[#ffcc00] animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </div>
                <p class="font-semibold text-[#f0ece4] mb-1">Generating your tailored resume…</p>
                <p class="text-sm text-[#555]">Claude is rewriting your resume for this role. Refresh in a moment.</p>
            </div>

        @elseif ($application->status === 'failed')
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-10 text-center">
                <div class="w-12 h-12 bg-[#1a0000] border border-[#330000] rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-5 h-5 text-[#ff5555]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <p class="font-semibold text-[#f0ece4] mb-1">Generation failed</p>
                <p class="text-sm text-[#555] mb-5">Something went wrong while contacting Claude. Please try again.</p>
                <a href="{{ route('applications.create', ['resume_id' => $application->resume_id]) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                    Try Again
                </a>
            </div>

        @else
            {{-- Main content: Resume + Cover Letter --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                {{-- Tailored Resume (3/5) --}}
                @if (!empty($application->tailored_resume))
                    @php $tr = $application->tailored_resume; @endphp
                    <div class="lg:col-span-3 space-y-0 bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                        {{-- Resume header bar --}}
                        <div class="px-6 py-4 border-b border-[#1a1a1a]" x-data="{ pdfLoading: false }">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-1 h-5 bg-volt rounded-full"></div>
                                <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Tailored Resume</h2>
                            </div>

                            {{-- Template picker --}}
                            <div>
                                <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-3">Download as PDF</p>
                                <div class="grid grid-cols-3 gap-3">

                                    {{-- ─── EXECUTIVE ─────────────────────────── --}}
                                    <a href="{{ route('applications.pdf', $application) }}?template=executive"
                                        @click="pdfLoading = true; setTimeout(() => pdfLoading = false, 15000)"
                                        class="group block cursor-pointer rounded-xl overflow-hidden border border-[#2a2a2a] hover:border-[#C8FF00] transition-all"
                                        style="box-shadow: 0 0 0 0 rgba(200,255,0,0);"
                                        onmouseover="this.style.boxShadow='0 0 24px rgba(200,255,0,0.2)'"
                                        onmouseout="this.style.boxShadow='0 0 0 0 rgba(200,255,0,0)'">
                                        {{-- Mockup --}}
                                        <div class="bg-[#1e293b] p-3 h-24 flex gap-2">
                                            <div class="w-8 bg-[#0f172a] rounded-sm flex flex-col gap-1 p-1">
                                                <div class="h-1 bg-[#475569] rounded-full"></div>
                                                <div class="h-0.5 bg-[#334155] rounded-full"></div>
                                                <div class="h-0.5 bg-[#334155] rounded-full"></div>
                                            </div>
                                            <div class="flex-1 bg-white rounded-sm flex flex-col gap-1 p-1.5">
                                                <div class="h-1.5 w-3/4 bg-[#1e293b] rounded-full"></div>
                                                <div class="h-0.5 bg-[#cbd5e1] rounded-full"></div>
                                                <div class="h-0.5 w-5/6 bg-[#cbd5e1] rounded-full"></div>
                                                <div class="h-0.5 w-2/3 bg-[#cbd5e1] rounded-full"></div>
                                            </div>
                                        </div>
                                        {{-- Label --}}
                                        <div class="bg-[#0d0d0d] px-3 py-2.5 border-t border-[#1f1f1f]">
                                            <p class="text-[10px] font-bold tracking-widest text-[#f0ece4] group-hover:text-volt transition">EXECUTIVE</p>
                                            <p class="text-[9px] text-[#555] mt-0.5">Navy sidebar · Corporate</p>
                                        </div>
                                    </a>

                                    {{-- ─── MODERN ────────────────────────────── --}}
                                    <a href="{{ route('applications.pdf', $application) }}?template=modern"
                                        @click="pdfLoading = true; setTimeout(() => pdfLoading = false, 15000)"
                                        class="group block cursor-pointer rounded-xl overflow-hidden border border-[#2a2a2a] hover:border-[#C8FF00] transition-all transform hover:scale-[1.03]">
                                        {{-- Mockup --}}
                                        <div class="bg-white p-3 h-24 flex flex-col gap-1.5">
                                            <p class="text-[#0f172a] font-bold leading-none" style="font-size: 18px; letter-spacing: -0.5px;">M</p>
                                            <div class="h-0.5 w-6 bg-[#64748b] rounded-full mb-1"></div>
                                            <div class="h-0.5 bg-[#cbd5e1] rounded-full"></div>
                                            <div class="h-0.5 w-5/6 bg-[#cbd5e1] rounded-full"></div>
                                            <div class="h-0.5 w-3/4 bg-[#cbd5e1] rounded-full"></div>
                                        </div>
                                        {{-- Label --}}
                                        <div class="bg-[#0d0d0d] px-3 py-2.5 border-t border-[#1f1f1f]">
                                            <p class="text-[10px] font-bold tracking-widest text-[#f0ece4] group-hover:text-volt transition">MODERN</p>
                                            <p class="text-[9px] text-[#555] mt-0.5">Clean · Contemporary</p>
                                        </div>
                                    </a>

                                    {{-- ─── CLASSIC ───────────────────────────── --}}
                                    <a href="{{ route('applications.pdf', $application) }}?template=classic"
                                        @click="pdfLoading = true; setTimeout(() => pdfLoading = false, 15000)"
                                        class="group block cursor-pointer rounded-xl overflow-hidden border border-[#2a2a2a] hover:border-[#888] transition-all">
                                        {{-- Mockup --}}
                                        <div class="bg-[#f8f8f8] p-3 h-24 flex flex-col items-center gap-1">
                                            <div class="h-1 w-2/3 bg-black rounded-full mt-0.5"></div>
                                            <div class="h-0.5 w-1/2 bg-[#888] rounded-full"></div>
                                            <div class="h-px w-full bg-black mt-1 mb-1"></div>
                                            <div class="h-0.5 w-full bg-[#aaa] rounded-full"></div>
                                            <div class="h-0.5 w-5/6 bg-[#aaa] rounded-full"></div>
                                            <div class="h-0.5 w-3/4 bg-[#aaa] rounded-full"></div>
                                        </div>
                                        {{-- Label --}}
                                        <div class="bg-[#0d0d0d] px-3 py-2.5 border-t border-[#1f1f1f]">
                                            <p class="text-[10px] font-bold tracking-widest text-[#f0ece4] group-hover:text-volt transition" style="font-family: 'Georgia', serif;">CLASSIC</p>
                                            <p class="text-[9px] text-[#555] mt-0.5">ATS-Friendly · Traditional</p>
                                        </div>
                                    </a>

                                </div>
                            </div>

                            {{-- PDF generation modal --}}
                            <div x-show="pdfLoading" x-cloak
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                class="fixed inset-0 z-[9999] flex items-center justify-center"
                                style="background-color: rgba(0,0,0,0.85); display: none;">

                                <div class="bg-[#111] border border-[#1f1f1f] rounded-2xl px-12 py-10 text-center max-w-sm mx-6"
                                     style="box-shadow: 0 0 60px rgba(200,255,0,0.15);">

                                    <div class="w-14 h-14 mx-auto mb-6 relative">
                                        <div class="absolute inset-0 rounded-full border-2 border-[#1f1f1f]"></div>
                                        <div class="absolute inset-0 rounded-full border-2 border-volt border-t-transparent animate-spin"></div>
                                    </div>

                                    <p class="font-heading text-2xl text-[#f0ece4] tracking-wide mb-2">POLISHING</p>
                                    <p class="text-sm text-[#888] leading-relaxed">
                                        Claude is polishing your resume<span class="inline-block animate-pulse">…</span>
                                    </p>
                                    <p class="text-xs text-[#444] mt-4">This may take up to 15 seconds</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-7 space-y-6">
                            {{-- Contact --}}
                            <div>
                                <h3 class="text-xl font-semibold text-[#f0ece4]">{{ $tr['full_name'] ?? '' }}</h3>
                                <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-[#555]">
                                    @if (!empty($tr['email'])) <span>{{ $tr['email'] }}</span> @endif
                                    @if (!empty($tr['phone'])) <span>{{ $tr['phone'] }}</span> @endif
                                    @if (!empty($tr['location'])) <span>{{ $tr['location'] }}</span> @endif
                                </div>
                            </div>

                            @if (!empty($tr['summary']))
                                <div class="border-t border-[#1a1a1a] pt-5">
                                    <p class="text-xs font-semibold text-volt uppercase tracking-widest mb-2">Summary</p>
                                    <p class="text-sm text-[#888] leading-relaxed">{{ $tr['summary'] }}</p>
                                </div>
                            @endif

                            @if (!empty($tr['work_experience']))
                                <div class="border-t border-[#1a1a1a] pt-5">
                                    <p class="text-xs font-semibold text-volt uppercase tracking-widest mb-4">Experience</p>
                                    <div class="space-y-5">
                                        @foreach ($tr['work_experience'] as $job)
                                            <div class="{{ !$loop->last ? 'pb-5 border-b border-[#161616]' : '' }}">
                                                <div class="flex items-start justify-between gap-3">
                                                    <div>
                                                        <p class="font-medium text-[#f0ece4] text-sm">{{ $job['title'] ?? '' }}</p>
                                                        <p class="text-xs text-[#555] mt-0.5">{{ $job['company'] ?? '' }}</p>
                                                    </div>
                                                    <p class="text-xs text-[#444] whitespace-nowrap shrink-0 mt-0.5">
                                                        {{ $job['start_date'] ?? '' }}{{ isset($job['end_date']) ? ' – '.$job['end_date'] : '' }}
                                                    </p>
                                                </div>
                                                @if (!empty($job['description']))
                                                    <p class="mt-2 text-xs text-[#666] leading-relaxed">{{ $job['description'] }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (!empty($tr['education']))
                                <div class="border-t border-[#1a1a1a] pt-5">
                                    <p class="text-xs font-semibold text-volt uppercase tracking-widest mb-4">Education</p>
                                    <div class="space-y-3">
                                        @foreach ($tr['education'] as $edu)
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <p class="font-medium text-[#f0ece4] text-sm">{{ $edu['degree'] ?? '' }}</p>
                                                    <p class="text-xs text-[#555] mt-0.5">{{ $edu['institution'] ?? '' }}</p>
                                                </div>
                                                @if (!empty($edu['year']))
                                                    <p class="text-xs text-[#444] shrink-0">{{ $edu['year'] }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (!empty($tr['skills']))
                                <div class="border-t border-[#1a1a1a] pt-5">
                                    <p class="text-xs font-semibold text-volt uppercase tracking-widest mb-3">Skills</p>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($tr['skills'] as $skill)
                                            @if ($skill)
                                                <span class="px-2.5 py-1 bg-[#0d0d0d] border border-[#2a2a2a] text-[#777] text-xs rounded-md">{{ $skill }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Cover Letter (2/5) --}}
                @if ($application->cover_letter)
                    <div class="lg:col-span-2 bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden flex flex-col">
                        <div class="flex items-center gap-3 px-6 py-4 border-b border-[#1a1a1a] shrink-0">
                            <div class="w-1 h-5 bg-volt rounded-full"></div>
                            <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Cover Letter</h2>
                        </div>
                        <div class="p-7 flex-1 overflow-y-auto">
                            <div class="text-sm text-[#888] leading-7 whitespace-pre-line">{{ $application->cover_letter }}</div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Original Job Description (collapsible) --}}
        <details class="group bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
            <summary class="flex items-center justify-between px-6 py-4 cursor-pointer select-none list-none text-xs font-semibold text-[#555] hover:text-[#888] transition uppercase tracking-widest">
                <span>Original Job Description</span>
                <svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </summary>
            <div class="px-6 pb-6 pt-4 border-t border-[#1a1a1a] text-sm text-[#555] whitespace-pre-line leading-relaxed">
                {{ $application->job_description }}
            </div>
        </details>

    </div>
</x-app-layout>
