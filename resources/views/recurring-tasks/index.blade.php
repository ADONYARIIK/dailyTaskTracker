<x-layouts.app title="Recurring Tasks">
    <x-page-section>
        <x-card>
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <a href="{{ route('tasks.index') }}"
                        class="mb-2 inline-flex items-center text-sm font-medium text-primary-600 hover:underline dark:text-primary-400">
                        &larr; {{ __('Back to tasks') }}
                    </a>
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        {{ __('Recurring Tasks') }}
                    </h1>
                </div>

                <a href="{{ route('recurring-tasks.create') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    {{ __('Create recurring task') }}
                </a>
            </div>

            <x-flash-message class="mt-4" />

            <div class="mt-6 overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">{{ __('Task') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Category') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Frequency') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Schedule') }}</th>
                            <th scope="col" class="px-6 py-3"><span class="sr-only">{{ __('Actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recurringTasks as $recurringTask)
                            <tr class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $recurringTask['title'] }}</p>
                                    @if ($recurringTask['description'])
                                        <p class="mt-1 max-w-md text-sm">
                                            {{ Str::limit($recurringTask['description'], 50) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $recurringTask['category']['name'] ?? __('Uncategorized') }}</td>
                                <td class="px-6 py-4">{{ $recurringTask['frequency_label'] }}</td>
                                <td class="px-6 py-4">
                                    @if ($recurringTask['frequency'] === 'weekly' && !empty($recurringTask['days']))
                                        {{ collect($recurringTask['days'])->map(fn ($day) => ucfirst(substr($day, 0, 3)))->join(', ') }}
                                    @elseif ($recurringTask['frequency'] === 'monthly' && $recurringTask['day_of_month'])
                                        {{ __('Day :day', ['day' => $recurringTask['day_of_month']]) }}
                                    @else
                                        —
                                    @endif
                                    @if ($recurringTask['start_date'] || $recurringTask['end_date'])
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            @if ($recurringTask['start_date'])
                                                {{ __('From') }}: {{ $recurringTask['start_date']->format('M d, Y') }}
                                            @endif
                                            @if ($recurringTask['end_date'])
                                                {{ __('To') }}: {{ $recurringTask['end_date']->format('M d, Y') }}
                                            @endif
                                        </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <a href="{{ route('recurring-tasks.edit', ['recurring_task' => $recurringTask['id']]) }}"
                                            class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-400">
                                            {{ __('Edit') }}
                                        </a>
                                        <form method="POST"
                                            action="{{ route('recurring-tasks.destroy', ['recurring_task' => $recurringTask['id']]) }}"
                                            onsubmit="return confirm('{{ __('Are you sure you want to delete this recurring task?') }}')">
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
                                <td colspan="5" class="px-6 py-8 text-center text-sm">
                                    {{ __('No recurring tasks found.') }}
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
