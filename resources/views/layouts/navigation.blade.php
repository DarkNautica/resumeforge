<nav x-data="{ open: false }" class="bg-[#0a0a0a] border-b border-[#1a1a1a] sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="font-heading text-2xl tracking-wide leading-none shrink-0">
                TAILOR<span class="text-volt">AI</span>
            </a>

            {{-- Desktop nav links --}}
            <div class="hidden md:flex items-center gap-8 absolute left-1/2 -translate-x-1/2">
                <a href="{{ url('/') }}"
                   class="text-sm font-medium transition {{ request()->is('/') ? 'text-[#f0ece4]' : 'text-[#666] hover:text-[#f0ece4]' }}">
                    Home
                </a>
                <a href="{{ url('/#how-it-works') }}"
                   class="text-sm font-medium text-[#666] hover:text-[#f0ece4] transition">
                    How It Works
                </a>
                <a href="{{ route('plans') }}"
                   class="text-sm font-medium transition {{ request()->routeIs('plans') ? 'text-[#f0ece4]' : 'text-[#666] hover:text-[#f0ece4]' }}">
                    Pricing
                </a>
                <a href="mailto:support@tailorai.app"
                   class="text-sm font-medium text-[#666] hover:text-[#f0ece4] transition">
                    Support
                </a>
            </div>

            {{-- Right side --}}
            <div class="hidden md:flex items-center gap-4 shrink-0">
                @auth
                    @if (auth()->user()->resumes()->exists())
                        <a href="{{ route('applications.create') }}"
                            class="px-4 py-1.5 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                            Tailor Resume
                        </a>
                    @endif

                    {{-- User dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-2 text-sm text-[#888] hover:text-[#f0ece4] transition">
                            <span class="w-7 h-7 rounded-full bg-[#1a1a1a] border border-[#2a2a2a] flex items-center justify-center text-xs font-semibold text-[#f0ece4]">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-cloak
                            class="absolute right-0 mt-2 w-48 bg-[#111] border border-[#222] rounded-xl shadow-xl z-50 overflow-hidden">

                            <div class="px-4 py-3 border-b border-[#1a1a1a]">
                                <p class="text-xs text-[#555]">Signed in as</p>
                                <p class="text-sm text-[#f0ece4] truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2.5 text-sm text-[#888] hover:text-[#f0ece4] hover:bg-[#161616] transition">
                                My Account
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2.5 text-sm text-[#888] hover:text-[#f0ece4] hover:bg-[#161616] transition">
                                My Resumes
                            </a>
                            <a href="{{ route('plans') }}"
                                class="block px-4 py-2.5 text-sm text-[#888] hover:text-[#f0ece4] hover:bg-[#161616] transition">
                                Billing
                            </a>

                            <div class="border-t border-[#1a1a1a]"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2.5 text-sm text-[#888] hover:text-[#ff5555] hover:bg-[#161616] transition">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm text-[#888] hover:text-[#f0ece4] transition">
                        Log in
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-1.5 bg-volt text-black text-sm font-semibold rounded-lg hover:bg-[#b3e600] transition">
                        Get Started
                    </a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button @click="open = !open" class="md:hidden text-[#666] hover:text-[#f0ece4] transition p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display:none"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak class="md:hidden border-t border-[#1a1a1a] bg-[#0d0d0d]" style="display:none">
        <div class="px-6 py-4 space-y-1">
            <a href="{{ url('/') }}" class="block py-2.5 text-sm font-medium text-[#888] hover:text-[#f0ece4]">Home</a>
            <a href="{{ url('/#how-it-works') }}" class="block py-2.5 text-sm font-medium text-[#888] hover:text-[#f0ece4]">How It Works</a>
            <a href="{{ route('plans') }}" class="block py-2.5 text-sm font-medium text-[#888] hover:text-[#f0ece4]">Pricing</a>
            <a href="mailto:support@tailorai.app" class="block py-2.5 text-sm font-medium text-[#888] hover:text-[#f0ece4]">Support</a>
        </div>
        <div class="border-t border-[#1a1a1a] px-6 py-4 space-y-1">
            @auth
                <p class="text-xs text-[#555] mb-2">{{ Auth::user()->email }}</p>
                <a href="{{ route('profile.edit') }}" class="block py-2.5 text-sm text-[#888]">My Account</a>
                <a href="{{ route('dashboard') }}" class="block py-2.5 text-sm text-[#888]">My Resumes</a>
                <a href="{{ route('plans') }}" class="block py-2.5 text-sm text-[#888]">Billing</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="py-2.5 text-sm text-[#ff5555]">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block py-2.5 text-sm text-[#888]">Log in</a>
                <a href="{{ route('register') }}" class="block py-2.5 text-sm font-semibold text-volt">Get Started →</a>
            @endauth
        </div>
    </div>
</nav>

<style>[x-cloak] { display: none !important; }</style>
