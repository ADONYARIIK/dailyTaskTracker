<?php

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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
