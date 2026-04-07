<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-12">

        {{-- Page header --}}
        <div class="mb-10">
            <a href="{{ route('resumes.show', $resume) }}" class="inline-flex items-center gap-1.5 text-xs text-[#555] hover:text-[#f0ece4] transition mb-5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to resume
            </a>
            <h1 class="font-heading text-5xl text-[#f0ece4] leading-none">
                EDIT <span class="text-volt">RESUME</span>
            </h1>
            <p class="mt-3 text-sm text-[#555] truncate">{{ $resume->title }}</p>
        </div>

        <form method="POST" action="{{ route('resumes.update', $resume) }}" class="space-y-4">
            @csrf
            @method('PATCH')

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
                        <input type="text" name="title" value="{{ old('title', $resume->title) }}"
                            class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition" required>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">
                                Full Name <span class="text-volt">*</span>
                            </label>
                            <input type="text" name="full_name" value="{{ old('full_name', $resume->full_name) }}"
                                class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">
                                Email <span class="text-volt">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $resume->email) }}"
                                class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $resume->phone) }}"
                                class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Location</label>
                            <input type="text" name="location" value="{{ old('location', $resume->location) }}"
                                class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Professional Summary</label>
                        <textarea name="summary" rows="4"
                            class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition resize-none">{{ old('summary', $resume->summary) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Section: Work Experience --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden"
                x-data="{
                    positions: @js(old('work_experience', $resume->work_experience ?? [])),
                    addPosition() { this.positions.push({ title: '', company: '', start_date: '', end_date: '', description: '' }) },
                    removePosition(i) { this.positions.splice(i, 1) }
                }">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#1a1a1a]">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono text-volt">02</span>
                        <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Work Experience</h2>
                    </div>
                    <button type="button" @click="addPosition()"
                        class="text-xs font-semibold text-volt hover:underline">+ Add Position</button>
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="(pos, i) in positions" :key="i">
                        <div class="bg-[#0d0d0d] border border-[#222] rounded-lg p-5 space-y-4 relative">
                            <button type="button" @click="removePosition(i)"
                                class="absolute top-4 right-4 text-[#333] hover:text-[#ff5555] transition text-lg leading-none">&times;</button>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Job Title</label>
                                    <input type="text" :name="'work_experience[' + i + '][title]'" x-model="pos.title"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Company</label>
                                    <input type="text" :name="'work_experience[' + i + '][company]'" x-model="pos.company"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Start Date</label>
                                    <input type="text" :name="'work_experience[' + i + '][start_date]'" x-model="pos.start_date"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">End Date</label>
                                    <input type="text" :name="'work_experience[' + i + '][end_date]'" x-model="pos.end_date"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Description / Achievements</label>
                                <textarea :name="'work_experience[' + i + '][description]'" x-model="pos.description" rows="3"
                                    class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition resize-none"></textarea>
                            </div>
                        </div>
                    </template>
                    <p x-show="positions.length === 0" class="text-sm text-[#333] italic py-2">No positions added yet.</p>
                </div>
            </div>

            {{-- Section: Education --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden"
                x-data="{
                    educations: @js(old('education', $resume->education ?? [])),
                    addEducation() { this.educations.push({ degree: '', institution: '', year: '' }) },
                    removeEducation(i) { this.educations.splice(i, 1) }
                }">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#1a1a1a]">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono text-volt">03</span>
                        <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Education</h2>
                    </div>
                    <button type="button" @click="addEducation()"
                        class="text-xs font-semibold text-volt hover:underline">+ Add Education</button>
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="(edu, i) in educations" :key="i">
                        <div class="bg-[#0d0d0d] border border-[#222] rounded-lg p-5 relative">
                            <button type="button" @click="removeEducation(i)"
                                class="absolute top-4 right-4 text-[#333] hover:text-[#ff5555] transition text-lg leading-none">&times;</button>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Degree</label>
                                    <input type="text" :name="'education[' + i + '][degree]'" x-model="edu.degree"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Year</label>
                                    <input type="text" :name="'education[' + i + '][year]'" x-model="edu.year"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Institution</label>
                                    <input type="text" :name="'education[' + i + '][institution]'" x-model="edu.institution"
                                        class="w-full bg-[#111] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                                </div>
                            </div>
                        </div>
                    </template>
                    <p x-show="educations.length === 0" class="text-sm text-[#333] italic py-2">No education added yet.</p>
                </div>
            </div>

            {{-- Section: Skills --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden"
                x-data="{
                    skills: @js(old('skills', $resume->skills ?? [])),
                    addSkill() { this.skills.push('') },
                    removeSkill(i) { this.skills.splice(i, 1) }
                }">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#1a1a1a]">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-mono text-volt">04</span>
                        <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Skills</h2>
                    </div>
                    <button type="button" @click="addSkill()"
                        class="text-xs font-semibold text-volt hover:underline">+ Add Skill</button>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2" x-show="skills.length > 0">
                        <template x-for="(skill, i) in skills" :key="i">
                            <div class="flex items-center gap-1.5 bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg pl-3 pr-2 py-1.5">
                                <input type="text" :name="'skills[' + i + ']'" x-model="skills[i]"
                                    class="bg-transparent text-sm text-[#f0ece4] w-24 focus:outline-none">
                                <button type="button" @click="removeSkill(i)"
                                    class="text-[#333] hover:text-[#ff5555] transition text-base leading-none">&times;</button>
                            </div>
                        </template>
                    </div>
                    <p x-show="skills.length === 0" class="text-sm text-[#333] italic py-2">No skills added yet.</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-2">
                <form method="POST" action="{{ route('resumes.destroy', $resume) }}"
                    onsubmit="return confirm('Permanently delete this resume?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-[#333] hover:text-[#ff5555] transition">
                        Delete resume
                    </button>
                </form>
                <div class="flex items-center gap-4">
                    <a href="{{ route('resumes.show', $resume) }}" class="text-sm text-[#555] hover:text-[#f0ece4] transition">Cancel</a>
                    <button type="submit"
                        class="px-6 py-3 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>
