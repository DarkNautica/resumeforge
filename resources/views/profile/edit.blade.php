<x-app-layout>
    @php
        $user = auth()->user();
        $resumeCount  = $user->resumes()->count();
        $tailorCount  = $user->jobApplications()->count();
    @endphp

    <div class="max-w-3xl mx-auto px-6 py-12 space-y-6">

        {{-- Page header --}}
        <div class="mb-4">
            <p class="text-xs font-bold text-volt uppercase tracking-[0.2em] mb-3">Profile</p>
            <h1 class="font-heading text-5xl text-[#f0ece4] leading-none">
                YOUR <span class="text-volt">ACCOUNT</span>
            </h1>
        </div>

        {{-- Flash --}}
        @if (session('status') === 'profile-updated')
            <div class="flex items-center gap-3 bg-[#0d2600] border border-[#1a4a00] text-volt rounded-xl px-5 py-4 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Profile updated successfully.
            </div>
        @endif
        @if (session('status') === 'password-updated')
            <div class="flex items-center gap-3 bg-[#0d2600] border border-[#1a4a00] text-volt rounded-xl px-5 py-4 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Password changed successfully.
            </div>
        @endif

        {{-- ─── Card 1: Account Information ──────────────────────────── --}}
        <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-[#1a1a1a]">
                <span class="text-xs font-mono text-volt">01</span>
                <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Account Information</h2>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition">
                    @error('name', 'updateProfileInformation')
                        <p class="text-xs text-[#ff5555] mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#333] focus:outline-none focus:border-volt transition">
                    @error('email', 'updateProfileInformation')
                        <p class="text-xs text-[#ff5555] mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-6 py-3 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- ─── Card 2: Password ─────────────────────────────────────── --}}
        <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-[#1a1a1a]">
                <span class="text-xs font-mono text-volt">02</span>
                <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Password</h2>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Current Password</label>
                    <input type="password" name="current_password" autocomplete="current-password"
                        class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                    @error('current_password', 'updatePassword')
                        <p class="text-xs text-[#ff5555] mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">New Password</label>
                    <input type="password" name="password" autocomplete="new-password"
                        class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                    @error('password', 'updatePassword')
                        <p class="text-xs text-[#ff5555] mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" autocomplete="new-password"
                        class="w-full bg-[#0d0d0d] border border-[#2a2a2a] rounded-lg px-4 py-3 text-[#f0ece4] text-sm focus:outline-none focus:border-volt transition">
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-6 py-3 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        {{-- ─── Card 3: Account Stats ────────────────────────────────── --}}
        <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-[#1a1a1a]">
                <span class="text-xs font-mono text-volt">03</span>
                <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Account Stats</h2>
            </div>

            <div class="p-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Member Since</p>
                    <p class="font-heading text-2xl text-[#f0ece4] leading-none">{{ $user->created_at->format('M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Resumes</p>
                    <p class="font-heading text-2xl text-volt leading-none">{{ $resumeCount }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Tailors Run</p>
                    <p class="font-heading text-2xl text-volt leading-none">{{ $tailorCount }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Credits</p>
                    <p class="font-heading text-2xl text-[#f0ece4] leading-none">
                        {{ $user->isSubscribed() ? '∞' : $user->tailor_credits }}
                    </p>
                </div>
            </div>
        </div>

        {{-- ─── Card 4: Danger Zone ──────────────────────────────────── --}}
        <div class="bg-[#110000] border border-[#330000] rounded-xl overflow-hidden"
            x-data="{ confirming: false }">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-[#330000]">
                <span class="text-xs font-mono text-[#ff5555]">04</span>
                <h2 class="text-xs font-semibold text-[#ff5555] uppercase tracking-widest">Danger Zone</h2>
            </div>

            <div class="p-6 space-y-5">
                <div>
                    <p class="text-sm text-[#f0ece4] mb-1">Delete account</p>
                    <p class="text-xs text-[#666] leading-relaxed">
                        Permanently delete your account and all associated resumes, applications, and data. This cannot be undone.
                    </p>
                </div>

                <button type="button" x-show="!confirming" @click="confirming = true"
                    class="px-5 py-2.5 bg-[#1a0000] border border-[#330000] text-[#ff5555] text-sm font-semibold rounded-lg hover:border-[#ff5555] transition">
                    Delete Account
                </button>

                <form method="POST" action="{{ route('profile.destroy') }}" x-show="confirming" x-cloak class="space-y-4">
                    @csrf
                    @method('DELETE')

                    <div>
                        <label class="block text-xs font-medium text-[#888] uppercase tracking-widest mb-2">
                            Enter your password to confirm
                        </label>
                        <input type="password" name="password" autofocus required
                            class="w-full bg-[#1a0000] border border-[#330000] rounded-lg px-4 py-3 text-[#f0ece4] text-sm focus:outline-none focus:border-[#ff5555] transition">
                        @error('password', 'userDeletion')
                            <p class="text-xs text-[#ff5555] mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="px-5 py-2.5 bg-[#ff5555] text-white text-sm font-bold rounded-lg hover:bg-[#ff3333] transition">
                            Permanently Delete
                        </button>
                        <button type="button" @click="confirming = false"
                            class="text-sm text-[#666] hover:text-[#f0ece4] transition">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
