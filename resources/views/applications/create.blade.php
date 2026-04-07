<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tailor Resume to a Job
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($resumes->isEmpty())
                <div class="bg-white rounded-lg border border-dashed border-gray-300 p-10 text-center">
                    <p class="text-gray-500 mb-4">You need a resume before you can create an application.</p>
                    <a href="{{ route('resumes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                        Create a Resume
                    </a>
                </div>
            @else
                <form method="POST" action="{{ route('applications.store') }}" class="space-y-6">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 rounded-md px-4 py-3 text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Base Resume <span class="text-red-500">*</span></label>
                            <select name="resume_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                <option value="">Select a resume…</option>
                                @foreach ($resumes as $resume)
                                    <option value="{{ $resume->id }}" {{ old('resume_id', request('resume_id')) == $resume->id ? 'selected' : '' }}>
                                        {{ $resume->title }} — {{ $resume->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Job Title <span class="text-red-500">*</span></label>
                                <input type="text" name="job_title" value="{{ old('job_title') }}" placeholder="e.g. Senior Software Engineer"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Company Name <span class="text-red-500">*</span></label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="e.g. Acme Corp"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Job Description <span class="text-red-500">*</span></label>
                            <textarea name="job_description" rows="12" placeholder="Paste the full job description here…"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>{{ old('job_description') }}</textarea>
                            <p class="mt-1 text-xs text-gray-400">Paste the complete job posting for best results.</p>
                        </div>

                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:underline">Cancel</a>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                            Tailor My Resume
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
