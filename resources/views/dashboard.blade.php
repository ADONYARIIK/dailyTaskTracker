<x-layouts.app title="Dashboard">
    <x-page-section>
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ __('Dashboard') }}</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Here is your task overview for today.') }}</p>
            </div>

            <a href="{{ route('tasks.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-800">
                {{ __('Create task') }}
            </a>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-card class="border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Overdue tasks') }}</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['overdue'] }}</p>
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ __('Need your attention') }}</p>
            </x-card>
            <x-card class="border-l-4 border-green-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Completed today') }}</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['completed_today'] }}</p>
                <p class="mt-1 text-xs text-green-600 dark:text-green-400">{{ __('Completed since midnight') }}</p>
            </x-card>
            <x-card class="border-l-4 border-primary-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Completed in 7 days') }}</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $recentCompletions }}</p>
                <p class="mt-1 text-xs text-primary-600 dark:text-primary-400">{{ __('Including today') }}</p>
            </x-card>
            <x-card class="border-l-4 border-yellow-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Tasks due today') }}</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['tasks_today'] }}</p>
                <p class="mt-1 text-xs text-yellow-600 dark:text-yellow-400">{{ __('Keep your day on track') }}</p>
            </x-card>
        </div>

        <div @class([
            'mt-8 grid grid-cols-1 gap-6',
            'lg:grid-cols-2' => count($overdueTasks) > 0,
        ])>
            @if (count($overdueTasks) > 0)
                <x-card class="border border-red-200 dark:border-red-900/60">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-red-700 dark:text-red-300">{{ __('Overdue tasks') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Complete these tasks to get back on track.') }}</p>
                        </div>
                        <span
                            class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700 dark:bg-red-900/40 dark:text-red-300">{{ count($overdueTasks) }}</span>
                    </div>

                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($overdueTasks as $task)
                            <div class="flex flex-row items-center gap-3 group" data-task-item
                                data-completed="{{ $task['completed_at'] ? 'true' : 'false' }}">
                                <div>
                                    <button type="button" data-task-toggle data-task-id="{{ $task['id'] }}"
                                        aria-label="{{ $task['completed_at'] ? __('Mark incomplete') : __('Complete') }}"
                                        aria-pressed="{{ $task['completed_at'] ? 'true' : 'false' }}"
                                        class="inline-flex size-9 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-300 disabled:opacity-50 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-primary-400 dark:focus:ring-primary-800">
                                        <svg class="group-data-[completed=false]:block hidden size-6 text-primary-500 dark:text-primary-400"
                                            fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm0-2a6 6 0 1 0 0-12 6 6 0 0 0 0 12Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg class="group-data-[completed=true]:block hidden size-6 text-primary-600 dark:text-primary-400"
                                            fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.707-9.293a1 1 0 0 0-1.414-1.414L9 10.586 7.707 9.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between gap-4 py-4">
                                    <div class="min-w-0">
                                        <p
                                            class="truncate font-medium text-gray-900 dark:text-white group-data-[completed=true]:line-through">
                                            {{ $task['title'] }}
                                        </p>
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                            {{ __('Due :date', ['date' => $task['task_date']['display']]) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            @endif

            <x-card>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Today’s tasks') }}</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('What is on your list for :date.', ['date' => today()->format('M j')]) }}</p>
                    </div>
                    <a href="{{ route('tasks.index', ['from' => today()->toDateString(), 'to' => today()->toDateString()]) }}"
                        class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-400">{{ __('View all') }}</a>
                </div>

                @forelse ($upcomingTasks as $task)
                    <div class="flex flex-row items-center gap-3 group" data-task-item
                        data-completed="{{ $task['completed_at'] ? 'true' : 'false' }}">
                        <div>
                            <button type="button" data-task-toggle data-task-id="{{ $task['id'] }}"
                                aria-label="{{ $task['completed_at'] ? __('Mark incomplete') : __('Complete') }}"
                                aria-pressed="{{ $task['completed_at'] ? 'true' : 'false' }}"
                                class="inline-flex size-9 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-300 disabled:opacity-50 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-primary-400 dark:focus:ring-primary-800">
                                <svg class="group-data-[completed=false]:block hidden size-6 text-primary-500 dark:text-primary-400"
                                    fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm0-2a6 6 0 1 0 0-12 6 6 0 0 0 0 12Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <svg class="group-data-[completed=true]:block hidden size-6 text-primary-600 dark:text-primary-400"
                                    fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.707-9.293a1 1 0 0 0-1.414-1.414L9 10.586 7.707 9.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div
                            class="flex items-center justify-between gap-4 border-t border-gray-200 py-4 first:mt-4 dark:border-gray-700">
                            <div class="min-w-0">
                                <p @class([
                                    'truncate font-medium text-gray-900 dark:text-white group-data-[completed=true]:line-through',
                                    'line-through text-gray-500 dark:text-gray-400' => $task['completed_at'],
                                ])>{{ $task['title'] }}</p>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $task['category']['name'] ?? __('Uncategorized') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="mt-6 rounded-lg border border-dashed border-gray-300 px-6 py-10 text-center dark:border-gray-600">
                        <p class="font-medium text-gray-900 dark:text-white">{{ __('No tasks due today.') }}</p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Enjoy the clear schedule or plan your day.') }}</p>
                    </div>
                @endforelse
            </x-card>
        </div>
    </x-page-section>
    @push('scripts')
        @vite('resources/js/pages/dashboard.js')
    @endpush
</x-layouts.app>
