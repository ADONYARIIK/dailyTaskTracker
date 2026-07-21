@props([
    'task' => null,
    'categories',
    'action',
    'method' => 'POST',
    'submitLabel' => null,
    'afterSubmitLabel' => null,
])

<form method="POST" action="{{ $action }}" {{ $attributes->merge(['class' => 'space-y-4 md:space-y-6']) }}
    x-data="{ submitting: false }" @submit="submitting = true">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <x-input.label for="title" :value="__('Title')" />
        <x-input.text-input id="title" type="text" name="title" :value="old('title', $task['title'] ?? null)" required autofocus />
        <x-input.error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input.label for="description" :value="__('Description')" />
        <textarea id="description" name="description" rows="4"
            class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">{{ old('description', $task['description'] ?? null) }}</textarea>
        <x-input.error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input.label for="category_id" :value="__('Category')" />
            <select id="category_id" name="category_id"
                class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                <option value="">{{ __('No category') }}</option>
                @foreach ($categories as $categoryId => $category)
                    <option value="{{ $categoryId }}" @selected(old('category_id', $task['category']['id'] ?? null) === $categoryId)>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
            <x-input.error :messages="$errors->get('category_id')" class="mt-2" />
        </div>

        <div>
            <x-input.label for="task_date" :value="__('Due date')" />
            <x-input.text-input id="task_date" type="date" name="task_date" :value="old('task_date', $task['task_date']['datetime'] ?? null)" />
            <x-input.error :messages="$errors->get('task_date')" class="mt-2" />
        </div>
    </div>

    <div class="flex items-center justify-between gap-3">
        <a href="{{ route('tasks.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            {{ __('Cancel') }}
        </a>

        <x-input.primary-button :fullWidth="false" ::disabled="submitting">
            <span x-show="!submitting">{{ $submitLabel ?? ($task ? __('Update') : __('Create')) }}</span>
            <span x-show="submitting" x-cloak>
                {{ $afterSubmitLabel ?? ($task ? __('Updating...') : __('Creating...')) }}
            </span>
        </x-input.primary-button>
    </div>
</form>
