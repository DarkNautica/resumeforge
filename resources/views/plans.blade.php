<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-16 space-y-14">

        {{-- Header --}}
        <div class="text-center space-y-4">
            <p class="text-xs font-medium text-volt uppercase tracking-widest">Pricing</p>
            <h1 class="font-heading text-6xl text-[#f0ece4] leading-none">
                GET <span class="text-volt">ACCESS</span>
            </h1>
            <p class="text-[#555] text-base max-w-md mx-auto">
                Tailor your resume to any job in seconds. Pay once per use or go unlimited.
            </p>
        </div>

        @if (session('warning'))
            <div class="flex items-center gap-3 bg-[#1a1400] border border-[#332800] text-[#ffcc00] rounded-xl px-5 py-4 text-sm max-w-lg mx-auto">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ session('warning') }}
            </div>
        @endif

        {{-- Current balance --}}
        @auth
            <div class="flex items-center justify-center gap-6 text-sm">
                <div class="flex items-center gap-2 px-4 py-2 bg-[#111] border border-[#1f1f1f] rounded-xl">
                    <span class="text-[#555]">Credits:</span>
                    <span class="font-semibold text-[#f0ece4]">{{ auth()->user()->tailor_credits }}</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-[#111] border border-[#1f1f1f] rounded-xl">
                    <span class="text-[#555]">Plan:</span>
                    @if (auth()->user()->isSubscribed())
                        <span class="font-semibold text-volt">Unlimited</span>
                    @else
                        <span class="font-semibold text-[#888]">Pay-per-use</span>
                    @endif
                </div>
            </div>
        @endauth

        {{-- Pricing cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Credit card --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-2xl p-8 flex flex-col gap-6">
                <div>
                    <p class="text-xs font-semibold text-[#555] uppercase tracking-widest mb-3">Pay-per-use</p>
                    <div class="flex items-end gap-2">
                        <span class="font-heading text-6xl text-[#f0ece4] leading-none">$2.99</span>
                        <span class="text-[#555] text-sm mb-1">/ credit</span>
                    </div>
                    <p class="text-sm text-[#555] mt-3">One credit = one tailored resume + cover letter. No subscription required.</p>
                </div>

                <ul class="space-y-3 flex-1">
                    @foreach ([
                        'One AI-tailored resume',
                        'Matching cover letter',
                        'Download as PDF',
                        'No expiry on credits',
                    ] as $feature)
                        <li class="flex items-center gap-3 text-sm text-[#888]">
                            <svg class="w-4 h-4 text-volt shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                @auth
                    @if (auth()->user()->isSubscribed())
                        <button disabled class="w-full py-3.5 bg-[#1a1a1a] text-[#444] text-sm font-semibold rounded-xl cursor-not-allowed">
                            Active subscription — unlimited access
                        </button>
                    @else
                        <form method="POST" action="{{ route('billing.credit') }}">
                            @csrf
                            <button type="submit"
                                class="w-full py-3.5 border border-[#2a2a2a] text-[#f0ece4] text-sm font-semibold rounded-xl hover:border-volt hover:text-volt transition">
                                Buy a Credit
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="block w-full py-3.5 border border-[#2a2a2a] text-center text-[#f0ece4] text-sm font-semibold rounded-xl hover:border-volt hover:text-volt transition">
                        Sign in to Buy
                    </a>
                @endauth
            </div>

            {{-- Subscription card --}}
            <div class="bg-[#111] border border-volt rounded-2xl p-8 flex flex-col gap-6 relative overflow-hidden">
                {{-- Popular badge --}}
                <div class="absolute top-5 right-5">
                    <span class="px-2.5 py-1 bg-volt text-black text-xs font-bold rounded-lg">BEST VALUE</span>
                </div>

                <div>
                    <p class="text-xs font-semibold text-volt uppercase tracking-widest mb-3">Unlimited</p>
                    <div class="flex items-end gap-2">
                        <span class="font-heading text-6xl text-[#f0ece4] leading-none">$19</span>
                        <span class="text-[#555] text-sm mb-1">/ month</span>
                    </div>
                    <p class="text-sm text-[#555] mt-3">Unlimited tailoring for active job seekers. Cancel anytime.</p>
                </div>

                <ul class="space-y-3 flex-1">
                    @foreach ([
                        'Unlimited AI-tailored resumes',
                        'Unlimited cover letters',
                        'Download as PDF',
                        'Priority support',
                        'Cancel anytime',
                    ] as $feature)
                        <li class="flex items-center gap-3 text-sm text-[#888]">
                            <svg class="w-4 h-4 text-volt shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                @auth
                    @if (auth()->user()->isSubscribed())
                        <button disabled class="w-full py-3.5 bg-[#0d2600] border border-[#1a4a00] text-volt text-sm font-semibold rounded-xl cursor-not-allowed">
                            ✓ Currently subscribed
                        </button>
                    @else
                        <form method="POST" action="{{ route('billing.subscribe') }}">
                            @csrf
                            <button type="submit"
                                class="w-full py-3.5 bg-volt text-black text-sm font-bold rounded-xl hover:bg-[#b3e600] transition">
                                Subscribe — $19/mo
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="block w-full py-3.5 bg-volt text-black text-center text-sm font-bold rounded-xl hover:bg-[#b3e600] transition">
                        Sign in to Subscribe
                    </a>
                @endauth
            </div>
        </div>

        {{-- FAQ / reassurance --}}
        <div class="text-center space-y-2">
            <p class="text-xs text-[#444]">Payments processed securely by Stripe. No card details stored on our servers.</p>
            <p class="text-xs text-[#333]">Questions? Credits never expire. Subscriptions cancel with one click.</p>
        </div>

    </div>
</x-app-layout>
