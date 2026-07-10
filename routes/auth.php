<?php

use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLoginForm')
            ->name('login');
        Route::post('/login', 'login')
            ->name('login.post')
            ->middleware('throttle:login');

        Route::get('/register', 'showRegisterForm')
            ->name('register');
        Route::post('/register', 'register')
            ->name('register.post');
    });

    Route::controller(PasswordResetController::class)->group(function () {
        Route::get('/forgot-password', 'showPasswordResetRequestForm')
            ->name('password.request');

        Route::post('/forgot-password', 'sendPasswordResetEmail')
            ->middleware('throttle:password-reset-request')
            ->name('password.email');

        Route::get('/reset-password/{token}', 'showPasswordResetForm')
            ->name('password.reset');

        Route::post('/reset-password', 'resetPassword')
            ->middleware('throttle:password-reset')
            ->name('password.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'index'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:10,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
