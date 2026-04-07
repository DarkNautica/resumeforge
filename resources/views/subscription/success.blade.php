<x-app-layout>
    <div class="max-w-lg mx-auto px-6 py-24 text-center space-y-8">

        <div class="w-16 h-16 bg-[#0d2600] border border-[#1a4a00] rounded-2xl flex items-center justify-center mx-auto">
            <svg class="w-7 h-7 text-volt" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
        </div>

        <div class="space-y-3">
            <h1 class="font-heading text-5xl text-[#f0ece4] leading-none">
                {{ $type === 'subscription' ? 'YOU\'RE IN' : 'CREDIT ADDED' }}
            </h1>
            <p class="text-[#555] text-base">{{ $message }}</p>
        </div>

        @if ($type === 'subscription')
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl px-6 py-5 text-sm text-[#555] space-y-1">
                <p>Your subscription is now <span class="text-volt font-semibold">active</span>.</p>
                <p>Tailor as many resumes as you need — no limits.</p>
            </div>
        @else
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl px-6 py-5 text-sm text-[#555] space-y-1">
                <p>You now have <span class="text-volt font-semibold">{{ auth()->user()->tailor_credits }} credit{{ auth()->user()->tailor_credits !== 1 ? 's' : '' }}</span>.</p>
                <p>Credits never expire.</p>
            </div>
        @endif

        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('applications.create') }}"
                class="px-6 py-3 bg-volt text-black text-sm font-bold rounded-xl hover:bg-[#b3e600] transition">
                Tailor a Resume Now
            </a>
            <a href="{{ route('dashboard') }}"
                class="px-6 py-3 border border-[#2a2a2a] text-[#888] text-sm font-medium rounded-xl hover:border-[#444] hover:text-[#f0ece4] transition">
                Dashboard
            </a>
        </div>

    </div>
</x-app-layout>
