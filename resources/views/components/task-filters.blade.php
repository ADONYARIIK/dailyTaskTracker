@props(['categories', 'filters'])

<form method="GET" action="{{ route('tasks.index') }}" {{ $attributes->merge(['class' => 'grid gap-4 md:grid-cols-2 xl:grid-cols-5']) }}>
    <div>
        <x-input.label for="status" :value="__('Completion status')" />
        <select id="status" name="status"
            class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
            <option value="">{{ __('All tasks') }}</option>
            <option value="completed" @selected(($filters['status'] ?? null) === 'completed')>{{ __('Completed') }}</option>
            <option value="incomplete" @selected(($filters['status'] ?? null) === 'incomplete')>{{ __('Incomplete') }}</option>
        </select>
    </div>

    <div>
        <x-input.label for="category_id" :value="__('Category')" />
        <select id="category_id" name="category_id"
            class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
            <option value="">{{ __('All categories') }}</option>
            @foreach ($categories as $categoryId => $category)
                <option value="{{ $categoryId }}" @selected(($filters['category_id'] ?? null) === $categoryId)>{{ $category }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <x-input.label for="from" :value="__('From')" />
        <x-input.text-input id="from" type="date" name="from" :value="$filters['from'] ?? null" />
    </div>

    <div>
        <x-input.label for="to" :value="__('To')" />
        <x-input.text-input id="to" type="date" name="to" :value="$filters['to'] ?? null" />
    </div>

    <div class="flex items-end gap-3">
        <x-input.primary-button :fullWidth="false">{{ __('Filter') }}</x-input.primary-button>
        <a href="{{ route('tasks.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
            {{ __('Clear') }}
        </a>
    </div>
</form>
