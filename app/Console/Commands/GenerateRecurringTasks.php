<?php

namespace App\Console\Commands;

use App\Enums\TaskFrequency;
use App\Models\RecurringTask;
use App\Models\Task;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Nette\Utils\DateTime;

#[Signature('app:generate-recurring-tasks')]
#[Description('Generate recurring tasks')]
class GenerateRecurringTasks extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetDate = today();

        $recurringTasksQuery = RecurringTask::query()
            ->where(fn (Builder $query) => $query->whereNull('start_date')->orWhere('start_date', '<=', $targetDate))
            ->where(fn (Builder $query) => $query->whereNull('end_date')->orWhere('end_date', '>=', $targetDate))
            ->whereDoesntHave('tasks', fn ($query) => $query->whereDate('task_date', $targetDate));

        $totalRecurringTasks = $recurringTasksQuery->count();

        if (! $totalRecurringTasks) {
            $this->info('No active recurring tasks found.');

            return self::FAILURE;
        }

        $this->info('Processing '.$totalRecurringTasks->count().' recurring task templates...');

        $created = 0;
        $skipped = 0;

        $recurringTasksQuery->chunkById(
            250,
            function (Collection $recurringTasks) use ($targetDate, &$skipped, &$created) {
                try {
                    $insertTasksBatch = [];

                    foreach ($recurringTasks as $recurringTask) {
                        try {
                            if (! $this->isRecurringTaskDue($recurringTask, $targetDate)) {
                                $skipped++;

                                continue;
                            }

                            $now = new DateTime;

                            $insertTasksBatch[] = [
                                'uuid' => (string) Str::uuid7(),
                                'user_id' => $recurringTask->user_id,
                                'category_id' => $recurringTask->category_id,
                                'title' => $recurringTask->title,
                                'description' => $recurringTask->description,
                                'recurring_task_id' => $recurringTask->id,
                                'task_date' => $targetDate,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        } catch (\Exception $e) {
                            report($e);
                        }

                        $created++;
                    }

                    if ($insertTasksBatch) {
                        Task::insert($insertTasksBatch);

                        $created += \count($insertTasksBatch);
                    }
                } catch (\Exception $e) {
                    report($e);
                }
            }
        );

        $this->info('Created '.$created.' recurring tasks.');

        if ($skipped > 0) {
            $this->warn('Skipped '.$skipped.' recurring tasks.');
        }

        $this->newLine();

        return self::SUCCESS;
    }

    private function isRecurringTaskDue(RecurringTask $recurringTask, Carbon $targetDate)
    {
        return match ($recurringTask->frequency) {
            TaskFrequency::Daily => true,
            TaskFrequency::Weekdays => $targetDate->isWeekday(),
            TaskFrequency::Weekly => $this->isWeeklyRecurringTaskDue($recurringTask, $targetDate),
            TaskFrequency::Monthly => $this->isMonthlyRecurringTaskDue($recurringTask, $targetDate),
            default => false,
        };
    }

    private function isWeeklyRecurringTaskDue(RecurringTask $recurringTask, Carbon $targetDate)
    {
        $config = $recurringTask->frequency_config;

        if (! $config || ! isset($config['days']) || ! \is_array($config['days'])) {
            return false;
        }

        return \in_array(strtolower($targetDate->englishDayOfWeek), $config('days'));
    }

    private function isMonthlyRecurringTaskDue(RecurringTask $recurringTask, Carbon $targetDate)
    {
        $config = $recurringTask->frequency_config;

        if (! $config || ! isset($config['day'])) {
            return false;
        }

        $dayOfMonth = min($config['day'], $targetDate->dayInMonth);

        return $targetDate->day === $dayOfMonth;
    }
}
