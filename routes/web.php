<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/support', [SupportController::class, 'index'])->name('support');

// Legal
Route::view('/privacy', 'legal.privacy')->name('legal.privacy');
Route::view('/terms', 'legal.terms')->name('legal.terms');

// Pricing — visible to guests
Route::get('/plans', [SubscriptionController::class, 'plans'])->name('plans');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $resumes = auth()->user()->resumes()->orderByDesc('created_at')->get();
        $applications = auth()->user()->jobApplications()->with('resume')->orderByDesc('created_at')->take(10)->get();

        return view('dashboard', compact('resumes', 'applications'));
    })->name('dashboard');

    Route::resource('resumes', ResumeController::class)->except(['index']);
    Route::resource('applications', JobApplicationController::class)->only(['create', 'store', 'show']);
    Route::get('/applications/{application}/pdf', [JobApplicationController::class, 'downloadPdf'])->name('applications.pdf');

    // Billing
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::post('/billing/credit', [SubscriptionController::class, 'buyCredit'])->name('billing.credit');
    Route::post('/billing/subscribe', [SubscriptionController::class, 'subscribe'])->name('billing.subscribe');
    Route::post('/billing/cancel', [SubscriptionController::class, 'cancel'])->name('billing.cancel');
    Route::get('/billing/success', [SubscriptionController::class, 'success'])->name('subscription.success');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Stripe webhook — no auth, no CSRF
Route::post('/stripe/webhook', [SubscriptionController::class, 'webhook'])->name('stripe.webhook');

// Owner-only admin panel
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/darkroom', [AdminController::class, 'darkroom'])->name('admin.darkroom');
});

require __DIR__.'/auth.php';
