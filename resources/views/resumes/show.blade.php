<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-12 space-y-8">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">
            <div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-[#555] hover:text-[#f0ece4] transition mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Dashboard
                </a>
                <h1 class="font-heading text-4xl text-[#f0ece4] leading-none">{{ strtoupper($resume->title) }}</h1>
            </div>
            <div class="flex items-center gap-3 shrink-0 pt-9">
                <a href="{{ route('resumes.edit', $resume) }}"
                    class="px-4 py-2 border border-[#2a2a2a] text-[#888] text-sm font-medium rounded-lg hover:border-[#444] hover:text-[#f0ece4] transition">
                    Edit
                </a>
                <a href="{{ route('applications.create', ['resume_id' => $resume->id]) }}"
                    class="px-4 py-2 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                    Tailor to a Job
                </a>
            </div>
        </div>

        {{-- Contact --}}
        <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-7">
            <h2 class="text-2xl font-semibold text-[#f0ece4]">{{ $resume->full_name }}</h2>
            <div class="mt-3 flex flex-wrap gap-x-5 gap-y-1.5">
                <span class="flex items-center gap-1.5 text-sm text-[#666]">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $resume->email }}
                </span>
                @if ($resume->phone)
                    <span class="flex items-center gap-1.5 text-sm text-[#666]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $resume->phone }}
                    </span>
                @endif
                @if ($resume->location)
                    <span class="flex items-center gap-1.5 text-sm text-[#666]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $resume->location }}
                    </span>
                @endif
            </div>
            @if ($resume->summary)
                <p class="mt-5 text-sm text-[#888] leading-relaxed border-t border-[#1a1a1a] pt-5">{{ $resume->summary }}</p>
            @endif
        </div>

        {{-- Work Experience --}}
        @if (!empty($resume->work_experience))
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-7">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1 h-5 bg-volt rounded-full"></div>
                    <h3 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Work Experience</h3>
                </div>
                <div class="space-y-6">
                    @foreach ($resume->work_experience as $i => $job)
                        <div class="{{ !$loop->last ? 'pb-6 border-b border-[#1a1a1a]' : '' }}">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-[#f0ece4]">{{ $job['title'] ?? '' }}</p>
                                    <p class="text-sm text-[#666] mt-0.5">{{ $job['company'] ?? '' }}</p>
                                </div>
                                <p class="text-xs text-[#444] whitespace-nowrap mt-1 shrink-0">
                                    {{ $job['start_date'] ?? '' }}{{ isset($job['end_date']) ? ' – '.$job['end_date'] : '' }}
                                </p>
                            </div>
                            @if (!empty($job['description']))
                                <p class="mt-3 text-sm text-[#777] leading-relaxed">{{ $job['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Education --}}
        @if (!empty($resume->education))
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-7">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1 h-5 bg-volt rounded-full"></div>
                    <h3 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Education</h3>
                </div>
                <div class="space-y-4">
                    @foreach ($resume->education as $edu)
                        <div class="flex items-start justify-between gap-4 {{ !$loop->last ? 'pb-4 border-b border-[#1a1a1a]' : '' }}">
                            <div>
                                <p class="font-semibold text-[#f0ece4]">{{ $edu['degree'] ?? '' }}</p>
                                <p class="text-sm text-[#666] mt-0.5">{{ $edu['institution'] ?? '' }}</p>
                            </div>
                            @if (!empty($edu['year']))
                                <p class="text-xs text-[#444] shrink-0 mt-1">{{ $edu['year'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Skills --}}
        @if (!empty($resume->skills))
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-7">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-1 h-5 bg-volt rounded-full"></div>
                    <h3 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Skills</h3>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($resume->skills as $skill)
                        @if ($skill)
                            <span class="px-3 py-1 bg-[#0d0d0d] border border-[#2a2a2a] text-[#888] text-sm rounded-lg">{{ $skill }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
