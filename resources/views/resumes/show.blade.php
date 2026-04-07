<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $resume->title }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('applications.create', ['resume_id' => $resume->id]) }}"
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700 transition">
                    Tailor to a Job
                </a>
                <a href="{{ route('resumes.edit', $resume) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Contact --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-2xl font-bold text-gray-900">{{ $resume->full_name }}</h3>
                <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-gray-500">
                    <span>{{ $resume->email }}</span>
                    @if ($resume->phone) <span>{{ $resume->phone }}</span> @endif
                    @if ($resume->location) <span>{{ $resume->location }}</span> @endif
                </div>
                @if ($resume->summary)
                    <p class="mt-4 text-gray-700 text-sm leading-relaxed">{{ $resume->summary }}</p>
                @endif
            </div>

            {{-- Work Experience --}}
            @if (!empty($resume->work_experience))
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Work Experience</h4>
                    <div class="space-y-5">
                        @foreach ($resume->work_experience as $job)
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
                                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">{{ $job['description'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Education --}}
            @if (!empty($resume->education))
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Education</h4>
                    <div class="space-y-3">
                        @foreach ($resume->education as $edu)
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

            {{-- Skills --}}
            @if (!empty($resume->skills))
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h4 class="font-semibold text-gray-900 mb-3">Skills</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($resume->skills as $skill)
                            @if ($skill)
                                <span class="inline-block bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full px-3 py-0.5 text-sm">{{ $skill }}</span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex justify-start">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:underline">&larr; Back to dashboard</a>
            </div>
        </div>
    </div>
</x-app-layout>
