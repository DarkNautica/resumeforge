<x-app-layout>
    <div class="bg-[#0a0a0a] min-h-screen py-20">

        {{-- Warning flash --}}
        @if (session('warning'))
            <div class="max-w-xl mx-auto mb-12 px-6">
                <div class="flex items-center gap-3 bg-[#1a1400] border border-[#332800] text-[#ffcc00] rounded-xl px-5 py-4 text-sm">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('warning') }}
                </div>
            </div>
        @endif

        {{-- ── Top section ─────────────────────────────────────────────── --}}
        <div class="text-center px-6 mb-16">
            <p class="text-xs font-bold text-[#C8FF00] uppercase tracking-[0.2em] mb-6">PRICING</p>

            <h1 class="font-['Bebas_Neue'] text-white leading-[0.9]" style="font-size: clamp(56px, 11vw, 110px);">
                LAND YOUR NEXT JOB<br>
                <span class="text-[#C8FF00]">FASTER.</span>
            </h1>

            <p class="mt-6 text-gray-400 text-base max-w-md mx-auto leading-relaxed">
                Stop sending generic resumes. TailorAI rewrites yours for every role in seconds — then writes the cover letter too.
            </p>

            @auth
                @if (auth()->user()->isSubscribed() || auth()->user()->tailor_credits > 0)
                    <div class="mt-8">
                        @if (auth()->user()->isSubscribed())
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-[#0d2600] border border-[#1a4a00] text-[#C8FF00] text-sm font-semibold rounded-full">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                Unlimited plan active
                            </span>
                        @else
                            <span class="inline-block px-4 py-2 bg-[#111] border border-[#222] text-gray-400 text-sm rounded-full">
                                {{ auth()->user()->tailor_credits }} credit{{ auth()->user()->tailor_credits !== 1 ? 's' : '' }} remaining
                            </span>
                        @endif
                    </div>
                @endif
            @endauth
        </div>

        {{-- ── Cards section ───────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto px-6 mb-16">

            {{-- LEFT CARD: Starter ─────────────────────────────────────── --}}
            <div class="bg-[#111] border border-[#222] rounded-2xl p-8 flex flex-col">
                <p class="text-xs font-bold text-[#C8FF00] uppercase tracking-widest mb-6">PAY PER USE</p>

                <div class="mb-3">
                    <span class="font-['Bebas_Neue'] text-7xl text-white leading-none">$2.99</span>
                    <span class="text-gray-400 ml-2">/ credit</span>
                </div>

                <p class="text-sm text-gray-500 leading-relaxed mb-8">
                    Pay only when you apply. One credit rewrites your resume <em class="text-gray-400">and</em> writes the cover letter for one specific role.
                </p>

                <ul class="space-y-3 mb-10">
                    @php
                        $starterFeatures = [
                            [true,  '1 AI-tailored resume'],
                            [true,  '1 matching cover letter'],
                            [true,  'PDF download included'],
                            [true,  'Credits never expire'],
                            [false, 'Unlimited tailoring'],
                            [false, 'Priority support'],
                        ];
                    @endphp
                    @foreach ($starterFeatures as [$included, $text])
                        <li class="flex items-center gap-3 text-sm {{ $included ? 'text-gray-300' : 'text-gray-600' }}">
                            @if ($included)
                                <svg class="w-4 h-4 text-[#C8FF00] shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-red-900 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                            {{ $text }}
                        </li>
                    @endforeach
                </ul>

                @auth
                    @if (auth()->user()->isSubscribed())
                        <button disabled class="mt-auto w-full py-4 bg-[#0d0d0d] border border-[#1a1a1a] text-gray-600 rounded-xl cursor-not-allowed text-sm font-semibold">
                            You have unlimited access
                        </button>
                    @else
                        <form method="POST" action="{{ route('billing.credit') }}" class="mt-auto">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-[#1a1a1a] border border-[#333] text-white rounded-xl hover:border-[#C8FF00] transition text-sm font-semibold">
                                Buy 1 Credit — $2.99
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="mt-auto block w-full py-4 bg-[#1a1a1a] border border-[#333] text-white text-center rounded-xl hover:border-[#C8FF00] transition text-sm font-semibold">
                        Sign in to Buy
                    </a>
                @endauth
            </div>

            {{-- RIGHT CARD: Unlimited ──────────────────────────────────── --}}
            <div class="bg-[#111] border-2 border-[#C8FF00] rounded-2xl p-8 flex flex-col relative animate-border-glow">

                {{-- MOST POPULAR badge --}}
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#C8FF00] text-black text-xs font-bold px-4 py-1 rounded-full uppercase tracking-wider whitespace-nowrap">
                    Most Popular
                </div>

                <p class="text-xs font-bold text-[#C8FF00] uppercase tracking-widest mb-6 mt-2">UNLIMITED</p>

                <div class="mb-1">
                    <span class="line-through text-gray-500 text-lg">$39/mo</span>
                </div>
                <div class="mb-2">
                    <span class="font-['Bebas_Neue'] text-7xl text-white leading-none">$19</span>
                    <span class="text-gray-400 ml-2">/ month</span>
                </div>
                <p class="text-[#C8FF00] text-sm font-bold mb-6">Save 51% — limited time</p>

                <p class="text-sm text-gray-500 leading-relaxed mb-8">
                    For serious job seekers who apply to multiple roles. Tailor every application perfectly. Cancel any time, no questions asked.
                </p>

                <ul class="space-y-3 mb-10">
                    @foreach ([
                        'Unlimited AI-tailored resumes',
                        'Unlimited cover letters',
                        'PDF download every time',
                        'Priority AI processing',
                        'Priority email support',
                        'Cancel anytime — no lock-in',
                    ] as $feature)
                        <li class="flex items-center gap-3 text-sm text-gray-300">
                            <svg class="w-4 h-4 text-[#C8FF00] shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                @auth
                    @if (auth()->user()->isSubscribed())
                        <button disabled class="mt-auto w-full py-4 bg-[#0d2600] border border-[#1a4a00] text-[#C8FF00] rounded-xl cursor-not-allowed text-sm font-bold">
                            ✓ You're subscribed
                        </button>
                    @else
                        <form method="POST" action="{{ route('billing.subscribe') }}" class="mt-auto">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-[#C8FF00] text-black font-bold rounded-xl hover:bg-[#d4ff00] transition text-sm">
                                Start Unlimited — $19/mo
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="mt-auto block w-full py-4 bg-[#C8FF00] text-black text-center font-bold rounded-xl hover:bg-[#d4ff00] transition text-sm">
                        Sign in to Subscribe
                    </a>
                @endauth
            </div>

        </div>

        {{-- ── Stats row ───────────────────────────────────────────────── --}}
        <div class="max-w-4xl mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="border border-[#222] rounded-xl p-6 text-center">
                    <p class="font-['Bebas_Neue'] text-5xl text-[#C8FF00] leading-none mb-1">14K+</p>
                    <p class="text-xs text-gray-500 uppercase tracking-widest">Resumes tailored</p>
                </div>
                <div class="border border-[#222] rounded-xl p-6 text-center">
                    <p class="font-['Bebas_Neue'] text-5xl text-white leading-none mb-1">4.9★</p>
                    <p class="text-xs text-gray-500 uppercase tracking-widest">Average rating</p>
                </div>
                <div class="border border-[#222] rounded-xl p-6 text-center">
                    <p class="font-['Bebas_Neue'] text-5xl text-white leading-none mb-1">3×</p>
                    <p class="text-xs text-gray-500 uppercase tracking-widest">More interviews</p>
                </div>
            </div>

            <div class="text-center mt-12 space-y-1.5">
                <p class="text-xs text-gray-700">Payments processed securely by Stripe. No card details stored on our servers.</p>
                <p class="text-xs text-gray-800">Credits never expire · Subscriptions renew monthly · Cancel with one click</p>
            </div>
        </div>

    </div>
</x-app-layout>
