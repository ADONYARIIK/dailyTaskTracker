<x-layouts.app title="Tasks">
    <x-page-section>
        <x-card>
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    {{ __('Tasks') }}
                </h1>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('recurring-tasks.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        {{ __('Recurring tasks') }}
                    </a>
                    <a href="{{ route('tasks.create') }}"
                        class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        {{ __('Create task') }}
                    </a>
                </div>
            </div>

            <x-flash-message class="mt-4" />

            <x-task-filters :categories="$categories" :filters="$filters" class="mt-6" />

            <div class="mt-6 overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">{{ __('Task') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Category') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Due date') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Status') }}</th>
                            <th scope="col" class="px-6 py-3"><span class="sr-only">{{ __('Actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <tr class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $task['title'] }}</p>
                                    @if ($task['description'])
                                        <p class="mt-1 max-w-md text-sm">{{ Str::limit($task['description'], 50) }}</p>
                                    @endif
                                    @if ($task['recurring_task_id'])
                                        <p class="mt-1 text-xs text-primary-600 dark:text-primary-400">
                                            {{ __('From recurring template') }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $task['category']['name'] ?? __('Uncategorized') }}</td>
                                <td class="px-6 py-4">{{ $task['task_date']?->format('M d, Y g:i A') ?? '—' }}</td>
                                <td class="px-6 py-4"><x-task-status :task="$task" /></td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <form method="POST"
                                            action="{{ route('tasks.toggle-completion', $task['id']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <x-input.secondary-button type="submit">
                                                {{ $task['completed_at'] ? __('Mark incomplete') : __('Complete') }}
                                            </x-input.secondary-button>
                                        </form>
                                        <a href="{{ route('tasks.edit', ['task' => $task['id']]) }}"
                                            class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-400">
                                            {{ __('Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('tasks.destroy', $task['id']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm font-medium text-red-600 hover:underline dark:text-red-400">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td colspan="5" class="px-6 py-8 text-center text-sm">{{ __('No tasks found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-6">
                {{ $links() }}
            </div>
        </x-card>
    </x-page-section>
</x-layouts.app>
