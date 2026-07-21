<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

Schedule::command('auth:clear-resets')->daily();
Schedule::command('app:generate-recurring-tasks')
    ->dailyAt('00:30')
    ->runInBackground()
    ->sendOutputTo(storage_path('logs/recurring-tasks.log'));
Schedule::command('app:archive-expired-recurring-tasks')->daily();
