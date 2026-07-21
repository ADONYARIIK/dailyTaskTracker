<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Actions\Category\ResolveCategory;
use App\Enums\TaskStatus;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class ListTasks
{
    public function __construct(private ResolveCategory $resolveCategory) {}

    public function execute(User $user, array $filters): LengthAwarePaginator
    {
        $categoryId = $this->resolveCategory->execute($user, $filters['category_id'] ?? null);

        return $user->tasks()
            ->with('category')
            ->when(($filters['status'] ?? null) === TaskStatus::Completed->value, fn ($query) => $query->whereNotNull('completed_at'))
            ->when(($filters['status'] ?? null) === TaskStatus::Incomplete->value, fn ($query) => $query->whereNull('completed_at'))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($filters['from'] ?? null, fn ($query) => $query->whereDate('task_date', '>=', $filters['from']))
            ->when($filters['to'] ?? null, fn ($query) => $query->whereDate('task_date', '<=', $filters['to']))
            ->latest()
            ->paginate();
    }
}
