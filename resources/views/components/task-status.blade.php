@props(['task'])

@if ($task['completed_at'])
    <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-800 dark:bg-green-900/40 dark:text-green-300">
        {{ __('Completed') }}
    </span>
@else
    <span class="inline-flex rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300">
        {{ __('Incomplete') }}
    </span>
@endif
