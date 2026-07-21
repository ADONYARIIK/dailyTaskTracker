<?php

declare(strict_types=1);

namespace App\Actions\RecurringTask;

use App\Actions\Category\ResolveCategory;
use App\Enums\TaskFrequency;
use App\Models\RecurringTask;
use App\Models\User;

class CreateRecurringTask
{
    public function __construct(private ResolveCategory $resolveCategory) {}

    public function execute(User $user, array $recurringTaskData): RecurringTask
    {
        $recurringTaskData['category_id'] = $this->resolveCategory->execute($user, $data['category_id'] ?? null);
        $recurringTaskData['frequency_config'] = TaskFrequency::from($recurringTaskData['frequency'])->buildConfig($recurringTaskData);

        unset($recurringTaskData['days'], $recurringTaskData['day_of_month']);

        return $user->recurringTasks()->create($recurringTaskData);
    }
}
