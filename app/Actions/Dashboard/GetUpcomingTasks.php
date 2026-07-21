<?php

declare(strict_types=1);

namespace App\Actions\Dashboard;

use App\Models\User;
use Carbon\Carbon;

class GetUpcomingTasks
{
    public function execute(User $user, Carbon $today, Carbon $tomorrow, int $limit = 10): array
    {
        return $user->tasks()
            ->with('category')
            ->whereNull('completed_at')
            ->whereBetween('task_date', [$today, $tomorrow])
            ->orderby('task_date')
            ->orderBy('created_at')
            ->limit($limit)
            ->get()
            ->toResourceCollection()
            ->resolve();
    }
}
