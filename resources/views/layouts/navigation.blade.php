<nav x-data="{ open: false, userMenu: false }" class="bg-[#0a0a0a] border-b border-[#1a1a1a] sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="font-heading text-2xl tracking-wide leading-none">
                TAILOR<span class="text-volt">AI</span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden sm:flex items-center gap-8">
                <a href="{{ route('dashboard') }}"
                   class="text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'text-[#f0ece4]' : 'text-[#666] hover:text-[#f0ece4]' }}">
                    Dashboard
                </a>
                <a href="{{ route('resumes.create') }}"
                   class="text-sm font-medium transition {{ request()->routeIs('resumes.create') ? 'text-[#f0ece4]' : 'text-[#666] hover:text-[#f0ece4]' }}">
                    New Resume
                </a>
            </div>

            {{-- Right side --}}
            <div class="hidden sm:flex items-center gap-4">
                @if (auth()->user()->resumes()->exists())
                    <a href="{{ route('applications.create') }}"
                        class="px-4 py-1.5 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                        Tailor Resume
                    </a>
                @endif

                {{-- User dropdown --}}
                <div class="relative" @click.outside="userMenu = false">
                    <button @click="userMenu = !userMenu"
                        class="flex items-center gap-2 text-sm text-[#888] hover:text-[#f0ece4] transition">
                        <span class="w-7 h-7 rounded-full bg-[#1a1a1a] border border-[#2a2a2a] flex items-center justify-center text-xs font-semibold text-[#f0ece4]">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-3.5 h-3.5 transition-transform" :class="userMenu ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="userMenu" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden shadow-2xl"
                        style="display: none;">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-3 text-sm text-[#888] hover:text-[#f0ece4] hover:bg-[#161616] transition">
                            Profile
                        </a>
                        <div class="border-t border-[#1a1a1a]"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-3 text-sm text-[#888] hover:text-[#f0ece4] hover:bg-[#161616] transition">
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile hamburger --}}
            <button @click="open = !open" class="sm:hidden text-[#666] hover:text-[#f0ece4] transition p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display:none"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" class="sm:hidden border-t border-[#1a1a1a] bg-[#0d0d0d]" style="display:none">
        <div class="px-6 py-4 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="block py-2.5 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-[#f0ece4]' : 'text-[#666]' }}">
                Dashboard
            </a>
            <a href="{{ route('resumes.create') }}"
                class="block py-2.5 text-sm font-medium text-[#666]">
                New Resume
            </a>
            <a href="{{ route('applications.create') }}"
                class="block py-2.5 text-sm font-medium text-[#666]">
                Tailor Resume
            </a>
        </div>
        <div class="border-t border-[#1a1a1a] px-6 py-4 space-y-1">
            <p class="text-xs text-[#555] mb-2">{{ Auth::user()->email }}</p>
            <a href="{{ route('profile.edit') }}" class="block py-2.5 text-sm text-[#666]">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="py-2.5 text-sm text-[#666]">Log out</button>
            </form>
        </div>
    </div>
</nav>
