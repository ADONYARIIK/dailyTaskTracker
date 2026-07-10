@props(['active' => false])

@php
    $classes = $active
        ? 'block rounded-lg bg-primary-50 dark:bg-primary-900/30 px-4 py-2 text-base font-medium text-primary-700 dark:text-primary-400'
        : 'block rounded-lg px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
