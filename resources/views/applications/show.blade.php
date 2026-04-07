<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $application->job_title }} at {{ $application->company_name }}
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">Based on: {{ $application->resume->title ?? '—' }}</p>
            </div>
            <div class="flex items-center gap-3">
                @php
                    $badge = match($application->status) {
                        'complete'   => 'bg-green-100 text-green-700',
                        'processing' => 'bg-yellow-100 text-yellow-700',
                        'failed'     => 'bg-red-100 text-red-700',
                        default      => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $badge }}">
                    {{ ucfirst($application->status) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-md px-4 py-3 text-sm">
                    {{ session('info') }}
                </div>
            @endif

            @if ($application->status === 'pending' || $application->status === 'processing')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                    <p class="text-yellow-800 font-medium">Your tailored resume is being generated…</p>
                    <p class="text-yellow-600 text-sm mt-1">Refresh this page in a moment to see the results.</p>
                </div>
            @elseif ($application->status === 'failed')
                <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
                    <p class="text-red-800 font-medium">Something went wrong while generating your resume.</p>
                    <p class="text-red-600 text-sm mt-1">Please try creating a new application.</p>
                </div>
            @else
                {{-- Tailored Resume --}}
                @if (!empty($application->tailored_resume))
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900 text-lg">Tailored Resume</h3>
                            {{-- PDF download button will go here --}}
                            <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition opacity-50 cursor-not-allowed" disabled title="PDF export coming soon">
                                Download PDF
                            </button>
                        </div>

                        @php $tr = $application->tailored_resume; @endphp

                        {{-- Contact --}}
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">{{ $tr['full_name'] ?? '' }}</h4>
                            <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1 text-sm text-gray-500">
                                @if (!empty($tr['email'])) <span>{{ $tr['email'] }}</span> @endif
                                @if (!empty($tr['phone'])) <span>{{ $tr['phone'] }}</span> @endif
                                @if (!empty($tr['location'])) <span>{{ $tr['location'] }}</span> @endif
                            </div>
                        </div>

                        @if (!empty($tr['summary']))
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Summary</h5>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $tr['summary'] }}</p>
                            </div>
                        @endif

                        @if (!empty($tr['work_experience']))
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Work Experience</h5>
                                <div class="space-y-4">
                                    @foreach ($tr['work_experience'] as $job)
                                        <div>
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $job['title'] ?? '' }}</p>
                                                    <p class="text-sm text-gray-600">{{ $job['company'] ?? '' }}</p>
                                                </div>
                                                <p class="text-sm text-gray-400 whitespace-nowrap ml-4">
                                                    {{ $job['start_date'] ?? '' }}{{ isset($job['end_date']) ? ' – '.$job['end_date'] : '' }}
                                                </p>
                                            </div>
                                            @if (!empty($job['description']))
                                                <p class="mt-1.5 text-sm text-gray-600 leading-relaxed">{{ $job['description'] }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (!empty($tr['education']))
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Education</h5>
                                <div class="space-y-2">
                                    @foreach ($tr['education'] as $edu)
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $edu['degree'] ?? '' }}</p>
                                                <p class="text-sm text-gray-600">{{ $edu['institution'] ?? '' }}</p>
                                            </div>
                                            @if (!empty($edu['year']))
                                                <p class="text-sm text-gray-400 ml-4">{{ $edu['year'] }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (!empty($tr['skills']))
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Skills</h5>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($tr['skills'] as $skill)
                                        @if ($skill)
                                            <span class="inline-block bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full px-3 py-0.5 text-sm">{{ $skill }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Cover Letter --}}
                @if ($application->cover_letter)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-gray-900 text-lg">Cover Letter</h3>
                        </div>
                        <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $application->cover_letter }}
                        </div>
                    </div>
                @endif
            @endif

            {{-- Original Job Description --}}
            <details class="bg-white rounded-lg shadow-sm border border-gray-200">
                <summary class="px-6 py-4 text-sm font-medium text-gray-700 cursor-pointer select-none">
                    View Original Job Description
                </summary>
                <div class="px-6 pb-5 text-sm text-gray-600 whitespace-pre-line leading-relaxed border-t border-gray-100 pt-4">
                    {{ $application->job_description }}
                </div>
            </details>

            <div class="flex justify-start">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:underline">&larr; Back to dashboard</a>
            </div>

        </div>
    </div>
</x-app-layout>
