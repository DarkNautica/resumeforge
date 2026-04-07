<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-16">

        {{-- Header --}}
        <div class="mb-12">
            <p class="text-xs font-bold text-volt uppercase tracking-[0.2em] mb-3">Legal</p>
            <h1 class="font-heading text-5xl sm:text-6xl text-[#f0ece4] leading-none">PRIVACY <span class="text-volt">POLICY</span></h1>
            <p class="mt-4 text-xs text-[#555]">Last updated: April 2026</p>
        </div>

        {{-- Body --}}
        <div class="space-y-10 text-sm text-[#bbb] leading-relaxed">

            <p class="text-[#888]">
                TailorAI ("we", "us", "our") is committed to protecting your privacy. This Privacy Policy
                explains what data we collect, how we use it, and the rights you have over your personal information.
            </p>

            {{-- 1 --}}
            <section>
                <h2 class="font-heading text-2xl text-[#f0ece4] mb-4">1. WHAT WE COLLECT</h2>
                <ul class="space-y-2 list-disc pl-5">
                    <li><strong class="text-[#f0ece4]">Account information:</strong> your name and email address when you register.</li>
                    <li><strong class="text-[#f0ece4]">Resume content:</strong> the work history, education, skills, and personal details you enter into your base resume.</li>
                    <li><strong class="text-[#f0ece4]">Job descriptions:</strong> the text of any job postings you paste into the tailoring tool.</li>
                    <li><strong class="text-[#f0ece4]">Generated content:</strong> the AI-generated resumes and cover letters produced by the service.</li>
                    <li><strong class="text-[#f0ece4]">Payment information:</strong> processed entirely by Stripe — we never see or store your card details.</li>
                    <li><strong class="text-[#f0ece4]">Usage data:</strong> session cookies needed to keep you logged in.</li>
                </ul>
            </section>

            {{-- 2 --}}
            <section>
                <h2 class="font-heading text-2xl text-[#f0ece4] mb-4">2. HOW WE USE IT</h2>
                <ul class="space-y-2 list-disc pl-5">
                    <li>To generate AI-tailored resumes and cover letters for the specific jobs you apply to.</li>
                    <li>To process subscription and credit payments via Stripe.</li>
                    <li>To send transactional emails (account confirmation, billing receipts, password resets).</li>
                    <li>To keep your account secure and authenticated across sessions.</li>
                </ul>
                <p class="mt-4 text-[#888]">
                    We do <strong class="text-[#f0ece4]">not</strong> sell your data, share it with advertisers, or use your resume content
                    to train any AI models.
                </p>
            </section>

            {{-- 3 --}}
            <section>
                <h2 class="font-heading text-2xl text-[#f0ece4] mb-4">3. DATA RETENTION</h2>
                <p class="mb-3">
                    Your resume and application data are retained for as long as your account is active. You can
                    permanently delete your account — and all associated data — at any time from your profile page.
                </p>
                <p class="text-[#888]">
                    Stripe retains payment records independently per their own retention policy and applicable financial regulations.
                </p>
            </section>

            {{-- 4 --}}
            <section>
                <h2 class="font-heading text-2xl text-[#f0ece4] mb-4">4. THIRD PARTIES</h2>
                <p class="mb-4">We rely on a small number of trusted third-party providers to operate the service:</p>
                <ul class="space-y-3 list-disc pl-5">
                    <li>
                        <strong class="text-[#f0ece4]">Anthropic</strong> — powers the AI behind every tailored resume and cover letter.
                        Resume content and job descriptions are sent to the Anthropic API for processing.
                        <a href="https://www.anthropic.com/legal/privacy" target="_blank" rel="noopener" class="text-volt hover:underline">Anthropic Privacy Policy</a>
                    </li>
                    <li>
                        <strong class="text-[#f0ece4]">Stripe</strong> — handles all payment processing.
                        <a href="https://stripe.com/privacy" target="_blank" rel="noopener" class="text-volt hover:underline">Stripe Privacy Policy</a>
                    </li>
                </ul>
            </section>

            {{-- 5 --}}
            <section>
                <h2 class="font-heading text-2xl text-[#f0ece4] mb-4">5. YOUR RIGHTS</h2>
                <p>
                    You can access, correct, or permanently delete your account and all associated data at any time
                    from the <span class="text-volt">Profile</span> page. Account deletion is immediate and irreversible — all of your
                    resumes, applications, and personal data are removed from our systems.
                </p>
            </section>

            {{-- 6 --}}
            <section>
                <h2 class="font-heading text-2xl text-[#f0ece4] mb-4">6. CONTACT</h2>
                <p>
                    Questions or concerns about this policy? Reach us at
                    <a href="{{ route('support') }}" class="text-volt hover:underline">support@tailorai.com</a>.
                </p>
            </section>

        </div>

        {{-- Footer link --}}
        <div class="mt-16 pt-8 border-t border-[#1f1f1f] flex items-center justify-between text-xs text-[#444]">
            <a href="{{ url('/') }}" class="hover:text-[#f0ece4] transition">← Back to TailorAI</a>
            <a href="{{ route('legal.terms') }}" class="hover:text-[#f0ece4] transition">Terms of Service →</a>
        </div>

    </div>
</x-app-layout>
