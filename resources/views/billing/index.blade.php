<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-12 space-y-8">

        {{-- Page header --}}
        <div>
            <p class="text-xs font-bold text-volt uppercase tracking-[0.2em] mb-3">Billing</p>
            <h1 class="font-heading text-5xl text-[#f0ece4] leading-none">
                MANAGE YOUR <span class="text-volt">PLAN</span>
            </h1>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="flex items-center gap-3 bg-[#0d2600] border border-[#1a4a00] text-volt rounded-xl px-5 py-4 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="flex items-center gap-3 bg-[#1a1400] border border-[#332800] text-[#ffcc00] rounded-xl px-5 py-4 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ session('warning') }}
            </div>
        @endif

        {{-- Current Plan card --}}
        <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-[#1a1a1a]">
                <div class="w-1 h-5 bg-volt rounded-full"></div>
                <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Current Plan</h2>
            </div>

            <div class="p-6 space-y-6">
                @if ($user->isSubscribed())
                    {{-- Subscribed --}}
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-heading text-3xl text-[#f0ece4] leading-none mb-2">UNLIMITED</p>
                            <p class="text-sm text-[#666]">$19/month · Unlimited tailoring</p>
                            @if ($user->isCanceling())
                                <span class="inline-flex items-center gap-1.5 mt-3 px-3 py-1 bg-[#1a1400] border border-[#332800] text-[#ffcc00] text-xs font-semibold rounded-lg">
                                    Cancelling at period end
                                </span>
                            @endif
                        </div>
                        @if (! $user->isCanceling())
                            <span class="px-3 py-1 bg-[#0d2600] border border-[#1a4a00] text-volt text-xs font-semibold rounded-lg">
                                Active
                            </span>
                        @endif
                    </div>

                    @if ($nextBillingDate)
                        <div class="border-t border-[#1a1a1a] pt-5">
                            <p class="text-xs font-medium text-[#555] uppercase tracking-widest mb-1">
                                {{ $user->isCanceling() ? 'Access ends' : 'Next billing date' }}
                            </p>
                            <p class="text-sm text-[#f0ece4]">{{ $nextBillingDate->format('F j, Y') }}</p>
                        </div>
                    @endif
                @else
                    {{-- Pay-per-use --}}
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-heading text-3xl text-[#f0ece4] leading-none mb-2">PAY PER USE</p>
                            <p class="text-sm text-[#666]">$2.99 per credit · No subscription</p>
                        </div>
                        <span class="px-3 py-1 bg-[#111] border border-[#222] text-[#888] text-xs font-semibold rounded-lg">
                            Starter
                        </span>
                    </div>

                    <div class="border-t border-[#1a1a1a] pt-5">
                        <p class="text-xs font-medium text-[#555] uppercase tracking-widest mb-2">Credits remaining</p>
                        <div class="flex items-baseline gap-2">
                            <span class="font-heading text-5xl text-volt leading-none">{{ $user->tailor_credits }}</span>
                            <span class="text-sm text-[#666]">credit{{ $user->tailor_credits !== 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Actions card --}}
        <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-[#1a1a1a]">
                <div class="w-1 h-5 bg-volt rounded-full"></div>
                <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Actions</h2>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @if (! $user->isSubscribed())
                    <form method="POST" action="{{ route('billing.subscribe') }}">
                        @csrf
                        <button type="submit"
                            class="w-full py-4 bg-volt text-black text-sm font-bold rounded-xl hover:bg-[#b3e600] transition"
                            style="box-shadow: 0 0 24px rgba(200,255,0,0.25);">
                            Upgrade to Unlimited
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('billing.credit') }}" class="{{ $user->isSubscribed() ? 'sm:col-span-2' : '' }}">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 border border-[#2a2a2a] text-[#f0ece4] text-sm font-semibold rounded-xl hover:border-volt hover:text-volt transition"
                        @if ($user->isSubscribed()) disabled @endif
                        @class(['opacity-40 cursor-not-allowed' => $user->isSubscribed()])>
                        Buy More Credits — $2.99
                    </button>
                </form>
            </div>
        </div>

        {{-- Cancel card (only when subscribed and not already cancelling) --}}
        @if ($user->isSubscribed() && ! $user->isCanceling())
            <div class="bg-[#110000] border border-[#330000] rounded-xl overflow-hidden"
                x-data="{ confirming: false, typed: '' }">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-[#330000]">
                    <div class="w-1 h-5 bg-[#ff5555] rounded-full"></div>
                    <h2 class="text-xs font-semibold text-[#ff5555] uppercase tracking-widest">Danger Zone</h2>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <p class="text-sm text-[#f0ece4] mb-1">Cancel your subscription</p>
                        <p class="text-xs text-[#666] leading-relaxed">
                            You'll keep unlimited access until your current billing period ends, then your account will revert to pay-per-use.
                        </p>
                    </div>

                    {{-- Step 1: reveal confirmation --}}
                    <button type="button"
                        x-show="!confirming"
                        @click="confirming = true"
                        class="px-5 py-2.5 bg-[#1a0000] border border-[#330000] text-[#ff5555] text-sm font-semibold rounded-lg hover:border-[#ff5555] transition">
                        Cancel Subscription
                    </button>

                    {{-- Step 2: type CANCEL to confirm --}}
                    <form method="POST" action="{{ route('billing.cancel') }}"
                        x-show="confirming" x-cloak class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-medium text-[#888] uppercase tracking-widest mb-2">
                                Type <span class="text-[#ff5555]">CANCEL</span> to confirm
                            </label>
                            <input type="text" name="confirmation" x-model="typed" autocomplete="off" autofocus
                                class="w-full bg-[#1a0000] border border-[#330000] rounded-lg px-4 py-3 text-[#f0ece4] text-sm placeholder-[#444] focus:outline-none focus:border-[#ff5555] transition"
                                placeholder="CANCEL">
                            @error('confirmation')
                                <p class="text-xs text-[#ff5555] mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" :disabled="typed !== 'CANCEL'"
                                :class="typed === 'CANCEL' ? 'bg-[#ff5555] text-white hover:bg-[#ff3333]' : 'bg-[#1a0000] text-[#444] cursor-not-allowed'"
                                class="px-5 py-2.5 text-sm font-bold rounded-lg transition">
                                Confirm Cancellation
                            </button>
                            <button type="button" @click="confirming = false; typed = ''"
                                class="text-sm text-[#666] hover:text-[#f0ece4] transition">
                                Keep my subscription
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
