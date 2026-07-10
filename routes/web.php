<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('')->name('profile.edit');

    Route::redirect('/', '/dashboard');
});

require __DIR__ . '/test.php';
