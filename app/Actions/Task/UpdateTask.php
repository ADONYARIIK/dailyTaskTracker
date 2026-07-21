<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Actions\Category\ResolveCategory;
use App\Models\Task;
use App\Models\User;

class UpdateTask
{
    public function __construct(private ResolveCategory $resolveCategory) {}

    public function execute(User $user, Task $task, array $data): Task
    {
        $data['category_id'] = $this->resolveCategory->execute($user, $data['category_id'] ?? null);

        $task->fill($data);
        $task->save();

        return $task;
    }
}
