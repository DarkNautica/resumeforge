<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TailorAI') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
        <style>[x-cloak] { display: none !important; }</style>
    </head>
    <body class="font-sans antialiased bg-[#0a0a0a] text-[#f0ece4]">
        @include('layouts.navigation')

        @isset($header)
            <div class="border-b border-[#1a1a1a]">
                <div class="max-w-7xl mx-auto px-6 py-5">
                    {{ $header }}
                </div>
            </div>
        @endisset

        <main>
            {{ $slot }}
        </main>

        {{-- ─── Global footer with legal links ────────────────────── --}}
        <footer class="bg-[#0a0a0a] border-t border-[#111] py-6 px-8 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-[#555]">
            <p>&copy; {{ date('Y') }} TailorAI. All rights reserved.</p>
            <div class="flex items-center gap-5">
                <a href="{{ route('legal.privacy') }}" class="hover:text-[#f0ece4] transition">Privacy Policy</a>
                <a href="{{ route('legal.terms') }}" class="hover:text-[#f0ece4] transition">Terms of Service</a>
                <a href="{{ route('support') }}" class="hover:text-[#f0ece4] transition">Support</a>
            </div>
        </footer>

        {{-- ─── Cookie consent banner ─────────────────────────────── --}}
        <div x-data="{
                accepted: localStorage.getItem('cookiesAccepted') === 'true',
                accept() {
                    localStorage.setItem('cookiesAccepted', 'true');
                    this.accepted = true;
                }
            }"
            x-show="!accepted"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="fixed bottom-0 left-0 right-0 bg-[#111] border-t border-[#222] p-4 flex flex-col sm:flex-row items-center justify-between gap-4 z-50">
            <p class="text-xs text-[#888] leading-relaxed text-center sm:text-left max-w-2xl">
                We use essential cookies to keep you logged in. By continuing to use TailorAI you accept our cookie use.
            </p>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('legal.privacy') }}"
                    class="text-xs text-[#888] hover:text-[#f0ece4] transition px-3 py-2">
                    Privacy Policy
                </a>
                <button @click="accept()"
                    class="px-4 py-2 bg-volt text-black text-xs font-bold rounded-lg hover:bg-[#b3e600] transition">
                    Accept
                </button>
            </div>
        </div>
    </body>
</html>
