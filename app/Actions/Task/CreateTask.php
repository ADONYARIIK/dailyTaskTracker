<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Actions\Category\ResolveCategory;
use App\Models\Task;
use App\Models\User;

class CreateTask
{
    /**
     * Create a new class instance.
     */
    public function __construct(private ResolveCategory $resolveCategory)
    {
        //
    }

    public function execute(array $taskData, User $user): Task
    {
        $taskData['category_id'] = $this->resolveCategory->execute($user, $taskData['category_id'] ?? null);

        return $user->tasks()->create($taskData);
    }
}
