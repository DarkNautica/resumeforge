<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Account - TailorAI</title>
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
        <h1 class="font-['Bebas_Neue'] text-[32px] text-white text-center leading-none tracking-wide">CREATE ACCOUNT</h1>
        <p class="text-[#666] text-sm text-center mt-2 mb-8">Start tailoring your resume in 60 seconds</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block text-[#888] text-sm font-medium mb-1">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="bg-[#1a1a1a] border border-[#222] text-white rounded-xl px-4 py-3 w-full focus:border-[#C8FF00] focus:outline-none placeholder-[#444]">
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-[#888] text-sm font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="bg-[#1a1a1a] border border-[#222] text-white rounded-xl px-4 py-3 w-full focus:border-[#C8FF00] focus:outline-none placeholder-[#444]">
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-[#888] text-sm font-medium mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="bg-[#1a1a1a] border border-[#222] text-white rounded-xl px-4 py-3 w-full focus:border-[#C8FF00] focus:outline-none placeholder-[#444]">
                @error('password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-[#888] text-sm font-medium mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="bg-[#1a1a1a] border border-[#222] text-white rounded-xl px-4 py-3 w-full focus:border-[#C8FF00] focus:outline-none placeholder-[#444]">
                @error('password_confirmation')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full bg-[#C8FF00] text-black font-bold py-3 rounded-xl hover:bg-[#d4ff00] transition">
                Create Account
            </button>

            <p class="text-center text-xs text-[#555] mt-3">No credit card required</p>
        </form>

        {{-- Login link --}}
        <p class="text-center text-sm text-[#666] mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-[#C8FF00] hover:underline">Sign in &rarr;</a>
        </p>
    </div>
</div>

</body>
</html>
