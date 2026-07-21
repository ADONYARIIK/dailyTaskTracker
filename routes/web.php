<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecurringTaskController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class)
        ->except(['show']);

    Route::resource('tasks', TaskController::class)
        ->except(['show']);
    Route::patch('tasks/{task}/toggle-completion', [TaskController::class, 'toggleCompletion'])
        ->middleware('can:manage,task')
        ->name('tasks.toggle-completion');

    Route::resource('recurring-tasks', RecurringTaskController::class)
        ->except(['show']);

    Route::redirect('/', '/dashboard');
});
