<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Resume
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('resumes.update', $resume) }}" x-data="resumeForm()" class="space-y-8">
                @csrf
                @method('PATCH')

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-md px-4 py-3 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Basic Info --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 text-base">Basic Information</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Resume Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $resume->title) }}"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name', $resume->full_name) }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $resume->email) }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $resume->phone) }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" name="location" value="{{ old('location', $resume->location) }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Professional Summary</label>
                        <textarea name="summary" rows="4"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('summary', $resume->summary) }}</textarea>
                    </div>
                </div>

                {{-- Work Experience --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900 text-base">Work Experience</h3>
                        <button type="button" @click="addJob()" class="text-sm text-indigo-600 hover:underline">+ Add position</button>
                    </div>

                    <template x-for="(job, index) in jobs" :key="index">
                        <div class="border border-gray-200 rounded-md p-4 space-y-3 relative">
                            <button type="button" @click="removeJob(index)" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-lg leading-none">&times;</button>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Job Title</label>
                                    <input type="text" :name="`work_experience[${index}][title]`" x-model="job.title"
                                        class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Company</label>
                                    <input type="text" :name="`work_experience[${index}][company]`" x-model="job.company"
                                        class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Start Date</label>
                                    <input type="text" :name="`work_experience[${index}][start_date]`" x-model="job.start_date"
                                        class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">End Date</label>
                                    <input type="text" :name="`work_experience[${index}][end_date]`" x-model="job.end_date"
                                        class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Description / Achievements</label>
                                <textarea :name="`work_experience[${index}][description]`" x-model="job.description" rows="3"
                                    class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                            </div>
                        </div>
                    </template>

                    <p x-show="jobs.length === 0" class="text-sm text-gray-400 italic">No positions added yet.</p>
                </div>

                {{-- Education --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900 text-base">Education</h3>
                        <button type="button" @click="addEdu()" class="text-sm text-indigo-600 hover:underline">+ Add education</button>
                    </div>

                    <template x-for="(edu, index) in educations" :key="index">
                        <div class="border border-gray-200 rounded-md p-4 space-y-3 relative">
                            <button type="button" @click="removeEdu(index)" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-lg leading-none">&times;</button>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Degree</label>
                                    <input type="text" :name="`education[${index}][degree]`" x-model="edu.degree"
                                        class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Institution</label>
                                    <input type="text" :name="`education[${index}][institution]`" x-model="edu.institution"
                                        class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Graduation Year</label>
                                    <input type="text" :name="`education[${index}][year]`" x-model="edu.year"
                                        class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </template>

                    <p x-show="educations.length === 0" class="text-sm text-gray-400 italic">No education added yet.</p>
                </div>

                {{-- Skills --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900 text-base">Skills</h3>
                        <button type="button" @click="addSkill()" class="text-sm text-indigo-600 hover:underline">+ Add skill</button>
                    </div>

                    <div class="flex flex-wrap gap-2" x-show="skills.length > 0">
                        <template x-for="(skill, index) in skills" :key="index">
                            <div class="flex items-center gap-1 bg-indigo-50 border border-indigo-200 rounded-full px-3 py-1">
                                <input type="text" :name="`skills[${index}]`" x-model="skills[index]"
                                    class="bg-transparent text-sm text-indigo-700 w-24 focus:outline-none">
                                <button type="button" @click="removeSkill(index)" class="text-indigo-400 hover:text-red-500 ml-1">&times;</button>
                            </div>
                        </template>
                    </div>

                    <p x-show="skills.length === 0" class="text-sm text-gray-400 italic">No skills added yet.</p>
                </div>

                <div class="flex items-center justify-between">
                    <form method="POST" action="{{ route('resumes.destroy', $resume) }}" onsubmit="return confirm('Delete this resume?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-500 hover:underline">Delete resume</button>
                    </form>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('resumes.show', $resume) }}" class="text-sm text-gray-500 hover:underline">Cancel</a>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function resumeForm() {
            return {
                jobs: @json(old('work_experience', $resume->work_experience ?? [])),
                educations: @json(old('education', $resume->education ?? [])),
                skills: @json(old('skills', $resume->skills ?? [])),
                addJob() {
                    this.jobs.push({ title: '', company: '', start_date: '', end_date: '', description: '' });
                },
                removeJob(i) { this.jobs.splice(i, 1); },
                addEdu() {
                    this.educations.push({ degree: '', institution: '', year: '' });
                },
                removeEdu(i) { this.educations.splice(i, 1); },
                addSkill() { this.skills.push(''); },
                removeSkill(i) { this.skills.splice(i, 1); },
            };
        }
    </script>
</x-app-layout>
