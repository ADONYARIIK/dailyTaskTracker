<?php

declare(strict_types=1);

namespace App\Actions\Dashboard;

use App\Models\User;
use Carbon\Carbon;

class GetRecentCompletions
{
    public function execute(User $user, Carbon $today, int $days = 7): int
    {
        return $user->tasks()
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', $today->copy()->subDays($days))
            ->count();
    }
}
