<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\TaskFrequency;
use App\Models\RecurringTask;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin RecurringTask
 */
class RecurringTaskResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category->uuid,
                'name' => $this->category->name,
            ]),
            'frequency' => $this->frequency->value,
            'frequency_label' => $this->frequencyLabel(),
            'frequency_config' => $this->frequency_config,
            'days' => $this->frequency_config['days'] ?? [],
            'day_of_month' => $this->frequency_config['day_of_month'] ?? null,
            'start_date' => (new DateTimeResource($this->start_date, false))->resolve($request),
            'end_date' => (new DateTimeResource($this->end_date, false))->resolve($request),
            'created_at' => (new DateTimeResource($this->created_at))->resolve($request),
            'updated_at' => (new DateTimeResource($this->updated_at))->resolve($request),
        ];
    }

    private function frequencyLabel(): string
    {
        return match ($this->frequency) {
            TaskFrequency::Daily => __('Daily'),
            TaskFrequency::Weekdays => __('Weekdays'),
            TaskFrequency::Weekly => __('Weekly'),
            TaskFrequency::Monthly => __('Monthly'),
        };
    }
}
