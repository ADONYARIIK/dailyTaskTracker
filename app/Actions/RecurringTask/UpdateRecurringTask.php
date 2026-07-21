<?php

declare(strict_types=1);

namespace App\Actions\RecurringTask;

use App\Actions\Category\ResolveCategory;
use App\Enums\TaskFrequency;
use App\Models\RecurringTask;
use App\Models\User;

class UpdateRecurringTask
{
    public function __construct(private ResolveCategory $resolveCategory) {}

    public function execute(User $user, RecurringTask $recurringTask, array $data): RecurringTask
    {
        $data['category_id'] = $this->resolveCategory->execute($user, $data['category_id'] ?? null);
        $data['frequency_config'] = TaskFrequency::from($data['frequency'])->buildConfig($data);

        unset($data['days'], $data['day_of_month']);

        $recurringTask->fill($data);
        $recurringTask->save();

        return $recurringTask;
    }
}
