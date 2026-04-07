<?php

use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $resumes = auth()->user()->resumes()->orderByDesc('created_at')->get();
        $applications = auth()->user()->jobApplications()->with('resume')->orderByDesc('created_at')->take(10)->get();

        return view('dashboard', compact('resumes', 'applications'));
    })->name('dashboard');

    Route::resource('resumes', ResumeController::class)->except(['index']);
    Route::resource('applications', JobApplicationController::class)->only(['create', 'store', 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
