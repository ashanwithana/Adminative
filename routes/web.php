<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\OtpAuthController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('auth.otp.request');
});

// Authentication Routes (OTP-based)
Route::prefix('auth')->name('auth.')->group(function () {
    // OTP Request & Verification
    Route::get('/login', [OtpAuthController::class, 'showRequestForm'])->name('otp.request');
    Route::post('/otp/send', [OtpAuthController::class, 'sendOtp'])->name('otp.send');
    Route::get('/otp/verify', [OtpAuthController::class, 'showVerifyForm'])->name('otp.verify');
    Route::post('/otp/verify', [OtpAuthController::class, 'verifyOtp'])->name('otp.verify.post');

    // Registration
    Route::get('/register', [OtpAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [OtpAuthController::class, 'register'])->name('register.post');

    // Logout
    Route::post('/logout', [OtpAuthController::class, 'logout'])->name('logout');
});

// Admin Panel Routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'user.active'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::resource('users', UserController::class);

        // Role Management
        Route::resource('roles', RoleController::class);

        // Activity Logs
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        // System Monitoring
        Route::prefix('system')->name('system.')->group(function () {
            Route::get('/telescope', function () {
                return redirect('/telescope');
            })->name('telescope')->middleware('can:access telescope');
        });
    });
