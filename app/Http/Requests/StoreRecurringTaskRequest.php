<?php

namespace App\Http\Requests;

use App\Enums\TaskFrequency;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecurringTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable'],
            'frequency' => ['required', Rule::enum(TaskFrequency::class)],
            'days' => ['required_if:frequency,' . TaskFrequency::Weekly->value, 'array', 'min:1'],
            'days.*' => ['string', Rule::in(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])],
            'day_of_month' => ['required_if:frequency,' . TaskFrequency::Monthly->value, 'integer', 'between:1,31'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }
}
