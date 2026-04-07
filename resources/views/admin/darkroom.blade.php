<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow,noarchive,nosnippet">

    <title>👑 DARKROOM</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0a0a0a] text-[#f0ece4]">

    <div class="max-w-7xl mx-auto px-6 py-12 space-y-10">

        {{-- ─── Custom header ────────────────────────────────────────── --}}
        <div class="border-b border-[#1f1f1f] pb-8">
            <div class="flex items-baseline gap-4 flex-wrap">
                <h1 class="font-heading text-5xl sm:text-6xl text-[#f0ece4] leading-none">
                    👑 DARKROOM
                </h1>
                <span class="font-mono text-xs text-[#444] truncate">
                    KingDarkNauticaDashboardBestDevEverControlPanel
                </span>
            </div>
            <p class="mt-3 text-xs text-[#555]">
                Authorized access only · You built this · Don't share this URL
            </p>
            <div class="mt-3 flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-xs text-[#444] hover:text-volt transition">← Back to dashboard</a>
                <span class="text-[#222]">·</span>
                <span class="text-xs text-[#444]">{{ now()->format('l, F j, Y · g:i A') }}</span>
            </div>
        </div>

        {{-- ─── Top stat row ─────────────────────────────────────────── --}}
        <section>
            <p class="text-xs font-semibold text-[#444] uppercase tracking-widest mb-4">Vital Signs</p>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-6">
                    <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-2">Total Users</p>
                    <p class="font-heading text-5xl text-volt leading-none">{{ number_format($totalUsers) }}</p>
                    <p class="text-xs text-[#444] mt-2">All-time signups</p>
                </div>

                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-6">
                    <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-2">Active Subscribers</p>
                    <p class="font-heading text-5xl text-volt leading-none">{{ number_format($activeSubscribers) }}</p>
                    <p class="text-xs text-[#444] mt-2">+{{ $cancelingSubscribers }} canceling</p>
                </div>

                <div class="bg-[#111] border border-volt rounded-xl p-6"
                     style="box-shadow: 0 0 30px rgba(200,255,0,0.1);">
                    <p class="text-[10px] font-medium text-volt uppercase tracking-widest mb-2">Estimated MRR</p>
                    <p class="font-heading text-5xl text-volt leading-none">${{ number_format($estimatedMrr) }}</p>
                    <p class="text-xs text-[#444] mt-2">Recurring monthly</p>
                </div>

                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-6">
                    <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-2">Total Tailors Run</p>
                    <p class="font-heading text-5xl text-volt leading-none">{{ number_format($totalApplications) }}</p>
                    <p class="text-xs text-[#444] mt-2">{{ $completedApplications }} complete · {{ $failedApplications }} failed</p>
                </div>

            </div>
        </section>

        {{-- ─── Second row ───────────────────────────────────────────── --}}
        <section>
            <p class="text-xs font-semibold text-[#444] uppercase tracking-widest mb-4">Activity</p>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-6">
                    <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-2">Today's Signups</p>
                    <p class="font-heading text-4xl text-[#f0ece4] leading-none">{{ number_format($signupsToday) }}</p>
                    <p class="text-xs text-[#444] mt-2">{{ now()->format('M j') }}</p>
                </div>

                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-6">
                    <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-2">This Week</p>
                    <p class="font-heading text-4xl text-[#f0ece4] leading-none">{{ number_format($signupsThisWeek) }}</p>
                    <p class="text-xs text-[#444] mt-2">{{ $signupsThisMonth }} this month</p>
                </div>

                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-6">
                    <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-2">Completed Tailors</p>
                    <p class="font-heading text-4xl text-[#f0ece4] leading-none">{{ number_format($completedApplications) }}</p>
                    <p class="text-xs text-[#444] mt-2">{{ $totalResumes }} base resumes built</p>
                </div>

                <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-6">
                    <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-2">Est. API Cost</p>
                    <p class="font-heading text-4xl text-[#ff5555] leading-none">${{ number_format($estimatedApiCost, 2) }}</p>
                    <p class="text-xs text-[#444] mt-2">Claude burn rate</p>
                </div>

            </div>
        </section>

        {{-- ─── Revenue breakdown ────────────────────────────────────── --}}
        <section>
            <p class="text-xs font-semibold text-[#444] uppercase tracking-widest mb-4">Revenue Snapshot</p>
            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl p-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-2">MRR (Subscriptions)</p>
                        <p class="font-heading text-3xl text-volt leading-none">${{ number_format($estimatedMrr) }}</p>
                        <p class="text-xs text-[#444] mt-2">{{ $activeSubscribers + $cancelingSubscribers }} × $19/mo</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-2">Credits Revenue (est.)</p>
                        <p class="font-heading text-3xl text-[#f0ece4] leading-none">${{ number_format($estimatedCreditRevenue, 2) }}</p>
                        <p class="text-xs text-[#444] mt-2">Approximate one-time sales</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest mb-2">Credits Outstanding</p>
                        <p class="font-heading text-3xl text-[#f0ece4] leading-none">{{ number_format($totalCreditsRemaining) }}</p>
                        <p class="text-xs text-[#444] mt-2">Unredeemed credits in user balances</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── Recent Signups ───────────────────────────────────────── --}}
        <section>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-1 h-5 bg-volt rounded-full"></div>
                <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Recent Signups</h2>
                <span class="px-2 py-0.5 bg-[#111] border border-[#1f1f1f] text-[#555] text-xs rounded-md ml-auto">
                    {{ $recentSignups->count() }}
                </span>
            </div>

            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                @if ($recentSignups->isEmpty())
                    <div class="p-8 text-center text-sm text-[#555]">No signups yet.</div>
                @else
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[#1a1a1a]">
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-[#555] uppercase tracking-widest">Name</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-[#555] uppercase tracking-widest">Email</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-[#555] uppercase tracking-widest">Plan</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-[#555] uppercase tracking-widest">Credits</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-[#555] uppercase tracking-widest">Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentSignups as $u)
                                <tr class="border-b border-[#161616] last:border-0 hover:bg-[#141414] transition">
                                    <td class="px-5 py-3 text-sm text-[#f0ece4]">{{ $u->name }}</td>
                                    <td class="px-5 py-3 text-sm text-[#888] font-mono text-xs">{{ $u->email }}</td>
                                    <td class="px-5 py-3 text-sm">
                                        @if ($u->subscription_status === 'active')
                                            <span class="px-2 py-0.5 bg-[#0d2600] border border-[#1a4a00] text-volt text-xs font-semibold rounded">Unlimited</span>
                                        @elseif ($u->subscription_status === 'canceling')
                                            <span class="px-2 py-0.5 bg-[#1a1400] border border-[#332800] text-[#ffcc00] text-xs font-semibold rounded">Canceling</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-[#111] border border-[#222] text-[#666] text-xs font-semibold rounded">PPU</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-sm text-[#888]">{{ $u->tailor_credits }}</td>
                                    <td class="px-5 py-3 text-xs text-[#555]">{{ $u->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        {{-- ─── Recent Tailors ───────────────────────────────────────── --}}
        <section>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-1 h-5 bg-volt rounded-full"></div>
                <h2 class="text-xs font-semibold text-[#f0ece4] uppercase tracking-widest">Recent Tailors</h2>
                <span class="px-2 py-0.5 bg-[#111] border border-[#1f1f1f] text-[#555] text-xs rounded-md ml-auto">
                    {{ $recentTailors->count() }}
                </span>
            </div>

            <div class="bg-[#111] border border-[#1f1f1f] rounded-xl overflow-hidden">
                @if ($recentTailors->isEmpty())
                    <div class="p-8 text-center text-sm text-[#555]">No tailors yet.</div>
                @else
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[#1a1a1a]">
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-[#555] uppercase tracking-widest">User</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-[#555] uppercase tracking-widest">Job Title</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-[#555] uppercase tracking-widest">Company</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-[#555] uppercase tracking-widest">Status</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-[#555] uppercase tracking-widest">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentTailors as $app)
                                <tr class="border-b border-[#161616] last:border-0 hover:bg-[#141414] transition">
                                    <td class="px-5 py-3 text-sm text-[#f0ece4]">{{ $app->user->name ?? '—' }}</td>
                                    <td class="px-5 py-3 text-sm text-[#888] truncate max-w-xs">{{ $app->job_title }}</td>
                                    <td class="px-5 py-3 text-sm text-[#888]">{{ $app->company_name }}</td>
                                    <td class="px-5 py-3 text-sm">
                                        <span class="px-2 py-0.5 bg-[#0d2600] border border-[#1a4a00] text-volt text-xs font-semibold rounded">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-xs text-[#555]">{{ $app->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        {{-- ─── Footer ───────────────────────────────────────────────── --}}
        <footer class="border-t border-[#1f1f1f] pt-8 pb-6 text-center">
            <p class="text-xs text-[#444]">
                Built by <span class="text-[#888]">Jayden Robbins</span>
                <span class="text-[#222] mx-2">·</span>
                <span class="text-volt font-semibold">TailorAI</span>
                <span class="text-[#222] mx-2">·</span>
                {{ now()->format('Y') }}
            </p>
            <p class="text-[10px] text-[#333] mt-2 font-mono">
                you're looking at the throne 👑
            </p>
        </footer>

    </div>

</body>
</html>
