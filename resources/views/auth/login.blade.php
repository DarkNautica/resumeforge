<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In - TailorAI</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=bebas-neue:400" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0a0a0a] antialiased">

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="bg-[#111] border border-[#222] rounded-2xl p-8 w-full max-w-md mx-auto">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="font-['Bebas_Neue'] text-3xl tracking-wide leading-none">
                TAILOR<span class="text-[#C8FF00]">AI</span>
            </a>
        </div>

        {{-- Header --}}
        <h1 class="font-['Bebas_Neue'] text-[32px] text-white text-center leading-none tracking-wide">WELCOME BACK</h1>
        <p class="text-[#666] text-sm text-center mt-2 mb-8">Sign in to your TailorAI account</p>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-4 text-sm text-[#C8FF00]">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-[#888] text-sm font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="bg-[#1a1a1a] border border-[#222] text-white rounded-xl px-4 py-3 w-full focus:border-[#C8FF00] focus:outline-none placeholder-[#444]">
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-[#888] text-sm font-medium mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="bg-[#1a1a1a] border border-[#222] text-white rounded-xl px-4 py-3 w-full focus:border-[#C8FF00] focus:outline-none placeholder-[#444]">
                @error('password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me & Forgot --}}
            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="w-4 h-4 rounded bg-[#1a1a1a] border-[#333] text-[#C8FF00] focus:ring-[#C8FF00] focus:ring-offset-0">
                    <span class="ml-2 text-sm text-[#666]">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[#C8FF00] hover:underline text-sm">
                        Forgot password?
                    </a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full bg-[#C8FF00] text-black font-bold py-3 rounded-xl hover:bg-[#d4ff00] transition">
                Sign In
            </button>
        </form>

        {{-- Register link --}}
        <p class="text-center text-sm text-[#666] mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-[#C8FF00] hover:underline">Get started &rarr;</a>
        </p>
    </div>
</div>

</body>
</html>
