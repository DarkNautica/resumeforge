<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-12">

        {{-- Page header --}}
        <div class="mb-10">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-[#555] hover:text-[#f0ece4] transition mb-5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Dashboard
            </a>
            <h1 class="font-heading text-5xl text-[#f0ece4] leading-none">
                BUILD YOUR <span class="text-volt">RESUME</span>
            </h1>
            <p class="mt-3 text-sm text-[#555]">This is your base resume. Claude will use it to tailor applications to specific jobs.</p>
        </div>

        <form method="POST" action="{{ route('resumes.store') }}" x-data="resumeForm()" class="space-y-4">
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

            {{-- Section: Basic Info --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-[#1a1a1a]">
                    <span class="text-xs font-mono text-volt">01</span>
                    <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Basic Information</h2>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">
                            Resume Title <span class="text-volt">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Senior Software Engineer Resume"
                            class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition" required>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">
                                Full Name <span class="text-volt">*</span>
                            </label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}"
                                class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">
                                Email <span class="text-volt">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Location</label>
                            <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. New York, NY"
                                class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Professional Summary</label>
                        <textarea name="summary" rows="4" placeholder="A brief overview of your experience and goals…"
                            class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition resize-none">{{ old('summary') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Section: Work Experience --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#1a1a1a]">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono text-volt">02</span>
                        <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Work Experience</h2>
                    </div>
                    <button type="button" @click="addJob()"
                        class="text-xs font-semibold text-volt hover:underline">+ Add position</button>
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="(job, index) in jobs" :key="index">
                        <div class="bg-[#0d0d0d] border border-[#222] rounded-lg p-5 space-y-4 relative">
                            <button type="button" @click="removeJob(index)"
                                class="absolute top-4 right-4 text-[#333] hover:text-[#ff5555] transition text-lg leading-none">&times;</button>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Job Title</label>
                                    <input type="text" :name="`work_experience[${index}][title]`" x-model="job.title"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Company</label>
                                    <input type="text" :name="`work_experience[${index}][company]`" x-model="job.company"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Start Date</label>
                                    <input type="text" :name="`work_experience[${index}][start_date]`" x-model="job.start_date" placeholder="Jan 2020"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">End Date</label>
                                    <input type="text" :name="`work_experience[${index}][end_date]`" x-model="job.end_date" placeholder="Present"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Description / Achievements</label>
                                <textarea :name="`work_experience[${index}][description]`" x-model="job.description" rows="3"
                                    class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition resize-none"></textarea>
                            </div>
                        </div>
                    </template>
                    <p x-show="jobs.length === 0" class="text-sm text-[#333] italic py-2">No positions added yet.</p>
                </div>
            </div>

            {{-- Section: Education --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#1a1a1a]">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono text-volt">03</span>
                        <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Education</h2>
                    </div>
                    <button type="button" @click="addEdu()"
                        class="text-xs font-semibold text-volt hover:underline">+ Add education</button>
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="(edu, index) in educations" :key="index">
                        <div class="bg-[#0d0d0d] border border-[#222] rounded-lg p-5 relative">
                            <button type="button" @click="removeEdu(index)"
                                class="absolute top-4 right-4 text-[#333] hover:text-[#ff5555] transition text-lg leading-none">&times;</button>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Degree</label>
                                    <input type="text" :name="`education[${index}][degree]`" x-model="edu.degree" placeholder="B.S. Computer Science"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Year</label>
                                    <input type="text" :name="`education[${index}][year]`" x-model="edu.year" placeholder="2018"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Institution</label>
                                    <input type="text" :name="`education[${index}][institution]`" x-model="edu.institution"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                            </div>
                        </div>
                    </template>
                    <p x-show="educations.length === 0" class="text-sm text-[#333] italic py-2">No education added yet.</p>
                </div>
            </div>

            {{-- Section: Skills --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#1a1a1a]">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono text-volt">04</span>
                        <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Skills</h2>
                    </div>
                    <button type="button" @click="addSkill()"
                        class="text-xs font-semibold text-volt hover:underline">+ Add skill</button>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2" x-show="skills.length > 0">
                        <template x-for="(skill, index) in skills" :key="index">
                            <div class="flex items-center gap-1.5 bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg pl-3 pr-2 py-1.5">
                                <input type="text" :name="`skills[${index}]`" x-model="skills[index]"
                                    class="bg-transparent text-sm text-[#f0ece4] w-24 focus:outline-none">
                                <button type="button" @click="removeSkill(index)"
                                    class="text-[#333] hover:text-[#ff5555] transition text-base leading-none">&times;</button>
                            </div>
                        </template>
                    </div>
                    <p x-show="skills.length === 0" class="text-sm text-[#333] italic py-2">No skills added yet.</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 pt-2">
                <a href="{{ route('dashboard') }}" class="text-sm text-[#555] hover:text-[#f0ece4] transition">Cancel</a>
                <button type="submit"
                    class="px-6 py-3 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                    Save Resume
                </button>
            </div>
        </form>
    </div>

    <script>
        function resumeForm() {
            return {
                jobs: @json(old('work_experience', [])),
                educations: @json(old('education', [])),
                skills: @json(old('skills', [])),
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
