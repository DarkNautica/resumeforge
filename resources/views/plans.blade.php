<x-app-layout>
    <div class="max-w-5xl mx-auto px-6 py-20 space-y-16">

        {{-- Warning flash --}}
        @if (session('warning'))
            <div class="flex items-center gap-3 bg-[#1a1400] border border-[#332800] text-[#ffcc00] rounded-xl px-5 py-4 text-sm max-w-xl mx-auto">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ session('warning') }}
            </div>
        @endif

        {{-- Hero --}}
        <div class="text-center space-y-6">

            {{-- Social proof avatars --}}
            <div class="flex items-center justify-center gap-3">
                <div class="flex -space-x-2">
                    @foreach (['1B', '2C', '3D', '4E', '5F'] as $i)
                        <div class="w-7 h-7 rounded-full bg-[#1a1a1a] border-2 border-[#0a0a0a] flex items-center justify-center text-[8px] font-bold text-[#555]">
                            {{ $i[1] }}
                        </div>
                    @endforeach
                </div>
                <p class="text-sm text-[#666]">
                    <span class="text-[#f0ece4] font-semibold">2,400+</span> job seekers already landing interviews faster
                </p>
            </div>

            <div>
                <h1 class="font-heading text-6xl sm:text-7xl text-[#f0ece4] leading-none">
                    LAND YOUR NEXT JOB<br><span class="text-volt">FASTER.</span>
                </h1>
                <p class="mt-5 text-[#555] text-base max-w-lg mx-auto leading-relaxed">
                    Stop sending generic resumes. TailorAI rewrites yours for every job in seconds — then writes the cover letter too.
                </p>
            </div>

        </div>

        {{-- Current status for logged-in users --}}
        @auth
            @if (auth()->user()->isSubscribed() || auth()->user()->tailor_credits > 0)
                <div class="flex items-center justify-center gap-4 text-sm">
                    <div class="flex items-center gap-2 px-4 py-2 bg-[#111] border border-[#1f1f1f] rounded-xl">
                        <span class="text-[#555]">Credits remaining:</span>
                        <span class="font-semibold text-[#f0ece4]">
                            {{ auth()->user()->isSubscribed() ? '∞' : auth()->user()->tailor_credits }}
                        </span>
                    </div>
                    @if (auth()->user()->isSubscribed())
                        <span class="px-3 py-1.5 bg-[#0d2600] border border-[#1a4a00] text-volt text-xs font-semibold rounded-xl">
                            Unlimited Active
                        </span>
                    @endif
                </div>
            @endif
        @endauth

        {{-- Pricing cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

            {{-- ── Card 1: Pay-per-use ─────────────────────────── --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-2xl p-8 flex flex-col gap-7">

                <div>
                    <p class="text-xs font-semibold text-[#444] uppercase tracking-widest mb-4">Starter</p>
                    <div class="flex items-end gap-2 mb-3">
                        <span class="font-heading text-7xl text-[#f0ece4] leading-none">$2.99</span>
                        <span class="text-[#444] text-sm mb-2">/ credit</span>
                    </div>
                    <p class="text-sm text-[#555] leading-relaxed">
                        Pay only when you need it. One credit tailors your resume <em>and</em> writes your cover letter for a specific role.
                    </p>
                </div>

                <ul class="space-y-3.5">
                    @php
                        $creditFeatures = [
                            ['icon' => true,  'text' => '1 AI-tailored resume'],
                            ['icon' => true,  'text' => '1 matching cover letter'],
                            ['icon' => true,  'text' => 'Download as PDF'],
                            ['icon' => true,  'text' => 'Credits never expire'],
                            ['icon' => false, 'text' => 'Unlimited tailoring'],
                            ['icon' => false, 'text' => 'Priority support'],
                        ];
                    @endphp
                    @foreach ($creditFeatures as $f)
                        <li class="flex items-center gap-3 text-sm {{ $f['icon'] ? 'text-[#888]' : 'text-[#2a2a2a]' }}">
                            @if ($f['icon'])
                                <svg class="w-4 h-4 text-volt shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 shrink-0 text-[#222]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                            {{ $f['text'] }}
                        </li>
                    @endforeach
                </ul>

                <div class="mt-auto">
                    @auth
                        @if (auth()->user()->isSubscribed())
                            <button disabled
                                class="w-full py-4 bg-[#0d0d0d] text-[#333] text-sm font-semibold rounded-xl cursor-not-allowed border border-[#1a1a1a]">
                                You have unlimited access
                            </button>
                        @else
                            <form method="POST" action="{{ route('billing.credit') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full py-4 border border-[#2a2a2a] text-[#f0ece4] text-sm font-semibold rounded-xl hover:border-volt hover:text-volt transition-all duration-150">
                                    Buy 1 Credit — $2.99
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full py-4 border border-[#2a2a2a] text-center text-[#f0ece4] text-sm font-semibold rounded-xl hover:border-volt hover:text-volt transition-all duration-150">
                            Sign in to Buy
                        </a>
                    @endauth
                    <p class="text-center text-xs text-[#333] mt-3">No account needed · Credits never expire</p>
                </div>
            </div>

            {{-- ── Card 2: Unlimited (glowing) ─────────────────── --}}
            <div class="bg-[#0f1a00] border border-volt rounded-2xl p-8 flex flex-col gap-7 relative"
                style="box-shadow: 0 0 0 1px #C8FF00, 0 0 50px rgba(200,255,0,0.10), 0 0 100px rgba(200,255,0,0.05);">

                {{-- MOST POPULAR badge --}}
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2">
                    <span class="px-4 py-1 bg-volt text-black text-xs font-bold rounded-full uppercase tracking-wider whitespace-nowrap">
                        Most Popular
                    </span>
                </div>

                <div class="pt-2">
                    <p class="text-xs font-semibold text-volt uppercase tracking-widest mb-4">Unlimited</p>
                    <div class="flex items-end gap-3 mb-1">
                        <span class="font-heading text-7xl text-[#f0ece4] leading-none">$19</span>
                        <div class="mb-2">
                            <p class="text-[#444] text-sm line-through">$39<span class="text-[#333]">/mo</span></p>
                            <p class="text-[#888] text-sm">/month</p>
                        </div>
                    </div>
                    <p class="text-xs text-volt font-semibold mb-3">Save 51% — limited time offer</p>
                    <p class="text-sm text-[#777] leading-relaxed">
                        For serious job seekers. Apply to every role with a perfectly tailored resume. Cancel anytime, no questions asked.
                    </p>
                </div>

                <ul class="space-y-3.5">
                    @foreach ([
                        'Unlimited AI-tailored resumes',
                        'Unlimited cover letters',
                        'PDF download every time',
                        'Priority AI processing',
                        'Priority email support',
                        'Cancel anytime — no lock-in',
                    ] as $feature)
                        <li class="flex items-center gap-3 text-sm text-[#aaa]">
                            <svg class="w-4 h-4 text-volt shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                <div class="mt-auto">
                    @auth
                        @if (auth()->user()->isSubscribed())
                            <button disabled
                                class="w-full py-4 bg-[#0d2600] border border-[#1a4a00] text-volt text-sm font-semibold rounded-xl cursor-not-allowed">
                                ✓ You're subscribed
                            </button>
                        @else
                            <form method="POST" action="{{ route('billing.subscribe') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full py-4 bg-volt text-black text-sm font-bold rounded-xl hover:bg-[#d4ff1a] transition-all duration-150"
                                    style="box-shadow: 0 0 20px rgba(200,255,0,0.25);">
                                    Start Unlimited — $19/mo
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full py-4 bg-volt text-black text-center text-sm font-bold rounded-xl hover:bg-[#d4ff1a] transition-all duration-150"
                            style="box-shadow: 0 0 20px rgba(200,255,0,0.25);">
                            Sign in to Subscribe
                        </a>
                    @endauth
                    <p class="text-center text-xs text-[#444] mt-3">Cancel anytime · Billed monthly · Secure checkout</p>
                </div>
            </div>

        </div>

        {{-- Trust bar --}}
        <div class="border-t border-[#141414] pt-10">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
                <div class="space-y-1.5">
                    <p class="font-heading text-4xl text-volt">14K+</p>
                    <p class="text-xs text-[#444] uppercase tracking-widest">Resumes tailored</p>
                </div>
                <div class="space-y-1.5">
                    <p class="font-heading text-4xl text-[#f0ece4]">4.9★</p>
                    <p class="text-xs text-[#444] uppercase tracking-widest">Average rating</p>
                </div>
                <div class="space-y-1.5">
                    <p class="font-heading text-4xl text-[#f0ece4]">3×</p>
                    <p class="text-xs text-[#444] uppercase tracking-widest">More interviews reported</p>
                </div>
            </div>
        </div>

        {{-- Fine print --}}
        <div class="text-center space-y-1.5">
            <p class="text-xs text-[#333]">
                Payments processed securely by Stripe. No card details stored on our servers.
            </p>
            <p class="text-xs text-[#2a2a2a]">
                Credits never expire · Subscriptions renew monthly · Cancel with one click in your account
            </p>
        </div>

    </div>
</x-app-layout>
