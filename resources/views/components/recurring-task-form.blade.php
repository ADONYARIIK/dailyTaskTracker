@props([
    'recurringTask' => null,
    'categories',
    'action',
    'method' => 'POST',
    'submitLabel' => null,
])

@php
    $weekdays = [
        'monday' => __('Mon'),
        'tuesday' => __('Tue'),
        'wednesday' => __('Wed'),
        'thursday' => __('Thu'),
        'friday' => __('Fri'),
        'saturday' => __('Sat'),
        'sunday' => __('Sun'),
    ];

    $selectedDays = old('days', $recurringTask['days'] ?? []);
    $selectedFrequency = old('frequency', $recurringTask['frequency'] ?? 'daily');
@endphp

{{-- @if ($errors->any())
    <pre>{{ dd($errors->all()) }}</pre>
@endif --}}

<form method="POST" action="{{ $action }}" x-data="{ frequency: @js($selectedFrequency) }"
    {{ $attributes->merge(['class' => 'space-y-4 md:space-y-6']) }}>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <x-input.label for="title" :value="__('Title')" />
        <x-input.text-input id="title" type="text" name="title" :value="old('title', $recurringTask['title'] ?? null)" required autofocus />
        <x-input.error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input.label for="description" :value="__('Description')" />
        <textarea id="description" name="description" rows="4"
            class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">{{ old('description', $recurringTask['description'] ?? null) }}</textarea>
        <x-input.error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div>
        <x-input.label for="category_id" :value="__('Category')" />
        <select id="category_id" name="category_id"
            class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
            <option value="">{{ __('No category') }}</option>
            @foreach ($categories as $categoryId => $categoryName)
                <option value="{{ $categoryId }}" @selected(old('category_id', $recurringTask['category']['id'] ?? null) === $categoryId)>
                    {{ $categoryName }}
                </option>
            @endforeach
        </select>
        <x-input.error :messages="$errors->get('category_id')" class="mt-2" />
    </div>

    <div>
        <x-input.label for="frequency" :value="__('Frequency')" />
        <select id="frequency" name="frequency" x-model="frequency"
            class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
            <option value="daily">{{ __('Daily') }}</option>
            <option value="weekdays">{{ __('Weekdays') }}</option>
            <option value="weekly">{{ __('Weekly') }}</option>
            <option value="monthly">{{ __('Monthly') }}</option>
        </select>
        <x-input.error :messages="$errors->get('frequency')" class="mt-2" />
    </div>

    <div x-show="frequency === 'weekly'" x-cloak>
        <x-input.label :value="__('Days of week')" />
        <div class="mt-2 flex flex-wrap gap-4">
            @foreach ($weekdays as $dayValue => $dayLabel)
                <label for="day_{{ $dayValue }}"
                    class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white">
                    <input id="day_{{ $dayValue }}" type="checkbox" name="days[]" value="{{ $dayValue }}"
                        @checked(in_array($dayValue, $selectedDays, true))
                        class="h-4 w-4 rounded border border-gray-300 bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                        x-bind:disabled="frequency !== 'weekly'" />
                    {{ $dayLabel }}
                </label>
            @endforeach
        </div>
        <x-input.error :messages="$errors->get('days')" class="mt-2" />
        <x-input.error :messages="$errors->get('days.*')" class="mt-2" />
    </div>

    <div x-show="frequency === 'monthly'" x-cloak>
        <x-input.label for="day_of_month" :value="__('Day of month')" />
        <x-input.text-input id="day_of_month" type="number" name="day_of_month" min="1" max="31"
            x-bind:disabled="frequency !== 'monthly'" :value="old('day_of_month', $recurringTask['day_of_month'] ?? null)" />
        <x-input.error :messages="$errors->get('day_of_month')" class="mt-2" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input.label for="start_date" :value="__('Start date')" />
            <x-input.text-input id="start_date" type="date" name="start_date" :value="old('start_date', ($recurringTask['start_date'] ?? null)?->toDateString())" />
            <x-input.error :messages="$errors->get('start_date')" class="mt-2" />
        </div>

        <div>
            <x-input.label for="end_date" :value="__('End date')" />
            <x-input.text-input id="end_date" type="date" name="end_date" :value="old('end_date', ($recurringTask['end_date'] ?? null)?->toDateString())" />
            <x-input.error :messages="$errors->get('end_date')" class="mt-2" />
        </div>
    </div>

    <div class="flex items-center justify-between gap-3">
        <a href="{{ route('recurring-tasks.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            {{ __('Cancel') }}
        </a>

        <x-input.primary-button :fullWidth="false">
            {{ $submitLabel ?? ($recurringTask ? __('Update') : __('Create')) }}
        </x-input.primary-button>
    </div>
</form>
