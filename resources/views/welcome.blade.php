<x-app-layout>

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- HERO                                                            --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none"
             style="background: radial-gradient(ellipse at top, rgba(200,255,0,0.05), transparent 60%);"></div>

        <div class="relative max-w-5xl mx-auto px-6 pt-24 pb-20 text-center">

            {{-- Eyebrow social proof --}}
            <div class="inline-flex items-center gap-3 mb-10 px-4 py-2 bg-[#111] border border-[#1f1f1f] rounded-full">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-volt opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-volt"></span>
                </span>
                <span class="text-xs text-[#888]">
                    <span class="text-[#f0ece4] font-semibold">2,400+</span> job seekers landing interviews faster
                </span>
            </div>

            {{-- Headline --}}
            <h1 class="font-heading text-white leading-[0.9]" style="font-size: clamp(56px, 11vw, 120px);">
                LAND YOUR NEXT JOB<br>
                <span class="text-volt">FASTER.</span>
            </h1>

            {{-- Subhead --}}
            <p class="mt-8 text-base sm:text-lg text-[#888] max-w-2xl mx-auto leading-relaxed">
                TailorAI rewrites your resume for every job in seconds, then writes the cover letter too.
                Built on Claude — the most advanced writing AI on the planet.
            </p>

            {{-- CTAs --}}
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="px-8 py-4 bg-volt text-black text-sm font-bold rounded-xl hover:bg-[#b3e600] transition"
                        style="box-shadow: 0 0 30px rgba(200,255,0,0.25);">
                        Go to Dashboard →
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-volt text-black text-sm font-bold rounded-xl hover:bg-[#b3e600] transition w-full sm:w-auto text-center"
                        style="box-shadow: 0 0 30px rgba(200,255,0,0.25);">
                        Get Started — Free
                    </a>
                    <a href="{{ route('login') }}"
                        class="px-8 py-4 border border-[#2a2a2a] text-[#f0ece4] text-sm font-semibold rounded-xl hover:border-volt hover:text-volt transition w-full sm:w-auto text-center">
                        Log In
                    </a>
                @endauth
            </div>

            <p class="mt-5 text-xs text-[#444]">No credit card required · Tailor in under 60 seconds</p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- HOW IT WORKS                                                    --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    <section id="how-it-works" class="border-t border-[#141414] py-24">
        <div class="max-w-5xl mx-auto px-6">

            <div class="text-center mb-16">
                <p class="text-xs font-bold text-volt uppercase tracking-[0.2em] mb-3">How It Works</p>
                <h2 class="font-heading text-5xl sm:text-6xl text-[#f0ece4] leading-none">
                    THREE STEPS. <span class="text-volt">SIXTY SECONDS.</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $steps = [
                        [
                            'num' => '01',
                            'title' => 'Build your base resume',
                            'body' => 'Tell us about your experience once. Add your work history, education, and skills. We store it securely so you never have to retype it.',
                        ],
                        [
                            'num' => '02',
                            'title' => 'Paste a job description',
                            'body' => 'Found a role you want? Copy the posting, pick your base resume, and let Claude work its magic. No prompts to write, no AI tricks to learn.',
                        ],
                        [
                            'num' => '03',
                            'title' => 'Download a tailored PDF',
                            'body' => 'Claude rewrites your resume to highlight the right experience and writes a matching cover letter. Download both as a polished PDF.',
                        ],
                    ];
                @endphp
                @foreach ($steps as $step)
                    <div class="bg-[#111] border border-[#1f1f1f] rounded-2xl p-7">
                        <p class="font-heading text-volt text-3xl mb-5">{{ $step['num'] }}</p>
                        <h3 class="text-lg font-semibold text-[#f0ece4] mb-3">{{ $step['title'] }}</h3>
                        <p class="text-sm text-[#666] leading-relaxed">{{ $step['body'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- SOCIAL PROOF / TESTIMONIALS                                     --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    <section class="border-t border-[#141414] py-24">
        <div class="max-w-5xl mx-auto px-6">

            <div class="text-center mb-16">
                <p class="text-xs font-bold text-volt uppercase tracking-[0.2em] mb-3">Loved by Job Seekers</p>
                <h2 class="font-heading text-5xl sm:text-6xl text-[#f0ece4] leading-none">
                    JOIN <span class="text-volt">2,400+</span> WHO<br>STOPPED SETTLING.
                </h2>
            </div>

            {{-- Stat row --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-14">
                @foreach ([
                    ['14K+',  'Resumes tailored'],
                    ['4.9★',  'Average user rating'],
                    ['3×',    'More interviews reported'],
                ] as [$stat, $label])
                    <div class="bg-[#111] border border-[#1f1f1f] rounded-xl px-6 py-7 text-center">
                        <p class="font-heading text-5xl text-volt leading-none mb-2">{{ $stat }}</p>
                        <p class="text-xs text-[#555] uppercase tracking-widest">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Testimonials --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $testimonials = [
                        [
                            'quote' => 'I was applying to 20 jobs a week and getting nothing. After three weeks with TailorAI I had 4 interviews booked. The cover letters alone are worth the price.',
                            'name'  => 'Marcus T.',
                            'role'  => 'Senior Engineer',
                        ],
                        [
                            'quote' => 'Finally, an AI tool that doesn\'t just spit out generic garbage. Claude actually reads the job posting and rewrites my resume to match. It\'s scary good.',
                            'name'  => 'Priya K.',
                            'role'  => 'Product Designer',
                        ],
                    ];
                @endphp
                @foreach ($testimonials as $t)
                    <div class="bg-[#111] border border-[#1f1f1f] rounded-2xl p-7">
                        <div class="flex mb-4 text-volt text-lg">★★★★★</div>
                        <p class="text-[#bbb] leading-relaxed mb-5">&ldquo;{{ $t['quote'] }}&rdquo;</p>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#1a1a1a] border border-[#2a2a2a] flex items-center justify-center text-sm font-semibold text-[#f0ece4]">
                                {{ $t['name'][0] }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[#f0ece4]">{{ $t['name'] }}</p>
                                <p class="text-xs text-[#555]">{{ $t['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- PRICING CTA                                                     --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    <section class="border-t border-[#141414] py-24">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <h2 class="font-heading text-5xl sm:text-6xl text-[#f0ece4] leading-none mb-5">
                START FROM <span class="text-volt">$2.99</span>
            </h2>
            <p class="text-[#666] text-base mb-10 max-w-md mx-auto">
                Pay-per-use credits or unlimited monthly. No contracts, no hidden fees, cancel any time.
            </p>
            <a href="{{ route('plans') }}"
                class="inline-block px-10 py-4 bg-volt text-black text-sm font-bold rounded-xl hover:bg-[#b3e600] transition"
                style="box-shadow: 0 0 30px rgba(200,255,0,0.25);">
                See Pricing →
            </a>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- FOOTER                                                          --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    <footer class="border-t border-[#141414] py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                {{-- Logo + tagline --}}
                <div>
                    <div class="font-heading text-2xl tracking-wide text-[#f0ece4]">
                        TAILOR<span class="text-volt">AI</span>
                    </div>
                    <p class="text-xs text-[#444] mt-2">Built with Claude. Crafted for job seekers.</p>
                </div>

                {{-- Links --}}
                <div class="flex flex-wrap gap-6 text-sm">
                    <a href="{{ url('/') }}" class="text-[#666] hover:text-[#f0ece4] transition">Home</a>
                    <a href="{{ url('/#how-it-works') }}" class="text-[#666] hover:text-[#f0ece4] transition">How It Works</a>
                    <a href="{{ route('plans') }}" class="text-[#666] hover:text-[#f0ece4] transition">Pricing</a>
                    <a href="{{ route('support') }}" class="text-[#666] hover:text-[#f0ece4] transition">Support</a>
                    @guest
                        <a href="{{ route('login') }}" class="text-[#666] hover:text-[#f0ece4] transition">Log in</a>
                    @endguest
                </div>
            </div>

            <div class="border-t border-[#141414] mt-10 pt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <p class="text-xs text-[#333]">&copy; {{ date('Y') }} TailorAI. All rights reserved.</p>
                <p class="text-xs text-[#333]">Payments secured by Stripe · Powered by Claude</p>
            </div>
        </div>
    </footer>

</x-app-layout>
