<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\UtilisationCertificateController;
use App\Http\Controllers\UCController;
use App\Http\Controllers\Auth\LoginController;

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Debug route - remove after testing
Route::get('/test-login', function() {
    $user = \App\Models\User::where('email', 'admin@college.edu')->first();
    Auth::login($user);
    return redirect()->route('dashboard');
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('expenditures', ExpenditureController::class);
    
    // UC Generator routes (admin only)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/uc', [UCController::class, 'index'])->name('uc.index');
        Route::post('/uc/generate', [UCController::class, 'generate'])->name('uc.generate');
        Route::get('/uc/download-pdf', [UCController::class, 'downloadPdf'])->name('uc.download-pdf');
    });
    
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/guide', function () {
        return view('guide');
    })->name('guide');
    
    // Multi-level approval routes
    Route::middleware(['role:admin,department_head'])->group(function () {
        Route::patch('/expenditures/{expenditure}/approve', [ExpenditureController::class, 'approve'])->name('expenditures.approve');
        Route::patch('/expenditures/{expenditure}/reject', [ExpenditureController::class, 'reject'])->name('expenditures.reject');
    });
});
