<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
            <a href="{{ route('resumes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                + New Resume
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-md px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Resumes --}}
            <section>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">My Resumes</h3>
                </div>

                @if ($resumes->isEmpty())
                    <div class="bg-white rounded-lg border border-dashed border-gray-300 p-10 text-center">
                        <p class="text-gray-500 mb-4">You haven't created a resume yet.</p>
                        <a href="{{ route('resumes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                            Create your first resume
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($resumes as $resume)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex flex-col gap-3">
                                <div>
                                    <h4 class="font-semibold text-gray-900 truncate">{{ $resume->title }}</h4>
                                    <p class="text-sm text-gray-500">{{ $resume->full_name }}</p>
                                    @if ($resume->location)
                                        <p class="text-sm text-gray-400">{{ $resume->location }}</p>
                                    @endif
                                </div>
                                <div class="mt-auto flex items-center gap-3 text-sm">
                                    <a href="{{ route('resumes.show', $resume) }}" class="text-indigo-600 hover:underline">View</a>
                                    <a href="{{ route('resumes.edit', $resume) }}" class="text-gray-500 hover:underline">Edit</a>
                                    <a href="{{ route('applications.create', ['resume_id' => $resume->id]) }}" class="text-emerald-600 hover:underline ml-auto">Tailor</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- Recent Applications --}}
            <section>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Applications</h3>
                    @if ($resumes->isNotEmpty())
                        <a href="{{ route('applications.create') }}" class="text-sm text-indigo-600 hover:underline">New application</a>
                    @endif
                </div>

                @if ($applications->isEmpty())
                    <div class="bg-white rounded-lg border border-dashed border-gray-300 p-10 text-center">
                        <p class="text-gray-500">No applications yet. Tailor a resume to a job to get started.</p>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 divide-y divide-gray-100">
                        @foreach ($applications as $app)
                            <div class="flex items-center justify-between px-5 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $app->job_title }} <span class="text-gray-500 font-normal">at {{ $app->company_name }}</span></p>
                                    <p class="text-sm text-gray-400">{{ $app->resume->title ?? '—' }} &middot; {{ $app->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    @php
                                        $badge = match($app->status) {
                                            'complete'   => 'bg-green-100 text-green-700',
                                            'processing' => 'bg-yellow-100 text-yellow-700',
                                            'failed'     => 'bg-red-100 text-red-700',
                                            default      => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium {{ $badge }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                    <a href="{{ route('applications.show', $app) }}" class="text-sm text-indigo-600 hover:underline">View</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

        </div>
    </div>
</x-app-layout>
