<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Resume;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function darkroom(): View
    {
        $now = Carbon::now();

        // ─── User counts ────────────────────────────────────────────
        $totalUsers       = User::count();
        $signupsToday     = User::whereDate('created_at', $now->toDateString())->count();
        $signupsThisWeek  = User::where('created_at', '>=', $now->copy()->startOfWeek())->count();
        $signupsThisMonth = User::where('created_at', '>=', $now->copy()->startOfMonth())->count();

        // ─── Content counts ─────────────────────────────────────────
        $totalResumes              = Resume::count();
        $totalApplications         = JobApplication::count();
        $completedApplications     = JobApplication::where('status', 'complete')->count();
        $failedApplications        = JobApplication::where('status', 'failed')->count();

        // ─── Billing ────────────────────────────────────────────────
        $totalCreditsRemaining = (int) User::sum('tailor_credits');
        $activeSubscribers     = User::where('subscription_status', 'active')->count();
        $cancelingSubscribers  = User::where('subscription_status', 'canceling')->count();

        $estimatedMrr = ($activeSubscribers + $cancelingSubscribers) * 19;

        // Approximate credit revenue: any non-subscriber who has any credits
        // OR who has run any tailors implies they paid at some point.
        $usersWhoBoughtCredits = User::whereNull('subscription_status')
            ->where(function ($q) {
                $q->where('tailor_credits', '>', 0)
                  ->orWhereHas('jobApplications');
            })
            ->count();
        $estimatedCreditRevenue = $usersWhoBoughtCredits * 2.99;

        // ─── API cost estimate ──────────────────────────────────────
        // ~$0.063 per completed tailor (Claude API roughly)
        $estimatedApiCost = $completedApplications * 0.063;

        // ─── Recent signups (10) ────────────────────────────────────
        $recentSignups = User::orderByDesc('created_at')->take(10)->get();

        // ─── Recent completed tailors (10) ──────────────────────────
        $recentTailors = JobApplication::with('user')
            ->where('status', 'complete')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('admin.darkroom', compact(
            'totalUsers',
            'signupsToday',
            'signupsThisWeek',
            'signupsThisMonth',
            'totalResumes',
            'totalApplications',
            'completedApplications',
            'failedApplications',
            'totalCreditsRemaining',
            'activeSubscribers',
            'cancelingSubscribers',
            'estimatedMrr',
            'estimatedCreditRevenue',
            'estimatedApiCost',
            'recentSignups',
            'recentTailors'
        ));
    }
}
