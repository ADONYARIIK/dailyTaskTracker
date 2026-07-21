<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Dashboard\GetDashboardStats;
use App\Actions\Dashboard\GetOverdueTasks;
use App\Actions\Dashboard\GetRecentCompletions;
use App\Actions\Dashboard\GetUpcomingTasks;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private GetDashboardStats $getDashboardStats,
        private GetUpcomingTasks $getUpcomingTasks,
        private GetOverdueTasks $getOverdueTasks,
        private GetRecentCompletions $getRecentCompletions,
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $today = today();
        $tomorrow = today()->addDay();

        return view(
            'dashboard',
            [
                'stats' => $this->getDashboardStats->execute($user, $today),
                'upcomingTasks' => $this->getUpcomingTasks->execute($user, $today, $tomorrow),
                'overdueTasks' => $this->getOverdueTasks->execute($user, $today),
                'recentCompletions' => $this->getRecentCompletions->execute($user, $today),
                'today' => $today,
            ],
        );
    }
}
