<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-16 space-y-12">

        {{-- ─── Header ──────────────────────────────────────────────── --}}
        <div class="text-center">
            <p class="text-xs font-bold text-volt uppercase tracking-[0.2em] mb-4">Support</p>
            <h1 class="font-heading text-6xl text-[#f0ece4] leading-none">
                GET <span class="text-volt">HELP</span>
            </h1>
            <p class="mt-5 text-[#666] text-base max-w-md mx-auto leading-relaxed">
                Need a hand? We're here to help. Browse the FAQ below or reach out directly.
            </p>
        </div>

        {{-- ─── Contact options ─────────────────────────────────────── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Email Support --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-2xl p-7">
                <div class="w-10 h-10 bg-[#0d2600] border border-[#1a4a00] rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-volt" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-[#f0ece4] mb-2">Email Support</h3>
                <p class="text-sm text-[#666] mb-4 leading-relaxed">
                    Send us a message and we'll get back to you with a hand.
                </p>
                <p class="font-mono text-sm text-volt mb-2">support@tailorai.com</p>
                <p class="text-xs text-[#444]">We respond within 24 hours</p>
            </div>

            {{-- Help Center --}}
            <div class="bg-[#111] border border-[#1f1f1f] rounded-2xl p-7">
                <div class="w-10 h-10 bg-[#0d2600] border border-[#1a4a00] rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-volt" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093M12 17h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-[#f0ece4] mb-2">Browse FAQs</h3>
                <p class="text-sm text-[#666] mb-4 leading-relaxed">
                    Most answers live below. Quick reads on credits, billing, and how it all works.
                </p>
                <a href="#faq" class="inline-flex items-center gap-1.5 text-sm text-volt font-semibold hover:underline">
                    Jump to FAQ
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                </a>
            </div>
        </div>

        {{-- ─── FAQ ─────────────────────────────────────────────────── --}}
        <div id="faq">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1 h-5 bg-volt rounded-full"></div>
                <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Frequently Asked Questions</h2>
            </div>

            @php
                $faqs = [
                    [
                        'q' => 'How does TailorAI work?',
                        'a' => 'You build a base resume once with your work history, education, and skills. When you find a job you want, you paste the job description into TailorAI. Claude reads the posting, rewrites your resume to highlight the most relevant experience, and writes a matching cover letter. You download both as a polished PDF in seconds.',
                    ],
                    [
                        'q' => 'How many credits do I need?',
                        'a' => 'One credit per job application. Each credit gives you a fully tailored resume and a matching cover letter for one specific role. Credits never expire, so you can stock up and use them whenever you find an opportunity worth applying for.',
                    ],
                    [
                        'q' => "What's the difference between Pay Per Use and Unlimited?",
                        'a' => 'Pay Per Use is $2.99 per tailor — perfect if you only apply to a handful of roles. Unlimited is $19/month and gives you unlimited tailoring, ideal if you\'re actively job searching and applying to multiple positions each week. Unlimited pays for itself after about 7 applications.',
                    ],
                    [
                        'q' => 'Can I cancel my subscription?',
                        'a' => 'Yes, you can cancel any time from your billing page with a single click. Your access continues until the end of your current billing period, so you\'ll never lose anything you\'ve already paid for. No phone calls, no retention emails, no questions asked.',
                    ],
                    [
                        'q' => 'Is my resume data secure?',
                        'a' => 'Yes. Your resume data is encrypted at rest and in transit, and we never share it with third parties. We don\'t use your data to train any AI models. Stripe handles all payment information — we never see or store your card details.',
                    ],
                    [
                        'q' => "What if the AI output isn't good?",
                        'a' => "We stand behind every tailor. If Claude's output doesn't meet your expectations, just contact support and we'll give you a free credit, no questions asked. We're constantly improving the prompts and quality checks behind the scenes.",
                    ],
                ];
            @endphp

            <div class="space-y-3" x-data="{ open: null }">
                @foreach ($faqs as $i => $faq)
                    <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                        <button type="button"
                            @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                            class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
                            <span class="text-sm font-semibold text-[#f0ece4]">{{ $faq['q'] }}</span>
                            <svg class="w-4 h-4 text-[#555] transition-transform shrink-0"
                                :class="open === {{ $i }} ? 'rotate-180 text-volt' : ''"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open === {{ $i }}" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="px-6 pb-5 text-sm text-[#888] leading-relaxed border-t border-[#1a1a1a] pt-4">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ─── Bottom CTA ──────────────────────────────────────────── --}}
        <div class="text-center bg-[#111] border border-[#1f1f1f] rounded-2xl p-10">
            <h3 class="font-heading text-3xl text-[#f0ece4] leading-none mb-3">STILL STUCK?</h3>
            <p class="text-sm text-[#666] mb-5 max-w-sm mx-auto">
                Reach out to <span class="text-volt font-semibold">support@tailorai.com</span> and a real human will help you out.
            </p>
            <p class="text-xs text-[#444]">Average response time: under 24 hours</p>
        </div>

    </div>
</x-app-layout>
