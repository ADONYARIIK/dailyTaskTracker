<?php

declare(strict_types=1);

namespace App\Actions\Dashboard;

use App\Models\User;
use Carbon\Carbon;

class GetDashboardStats
{
    public function execute(User $user, Carbon $today): array
    {
        $todayDate = $today->toDateString();

        $stats = $user->tasks()
            ->toBase()
            ->selectRaw(
                'COUNT(CASE WHEN task_date = ? THEN 1 END) AS tasks_today,
                COUNT(CASE WHEN task_date = ? AND completed_at IS NOT NULL THEN 1 END) AS completed_today,
                COUNT(CASE WHEN task_date < ? AND completed_at IS NULL THEN 1 END) AS overdue,
                COUNT(CASE WHEN completed_at IS NULL THEN 1 END) as total_pending',
                [$todayDate, $todayDate, $todayDate],
            )
            ->first();

        return [
            'tasks_today' => (int) $stats->tasks_today,
            'completed_today' => (int) $stats->completed_today,
            'overdue' => (int) $stats->overdue,
            'total_pending' => (int) $stats->total_pending,
        ];
    }
}
