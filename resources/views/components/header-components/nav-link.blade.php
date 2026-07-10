@props(['active' => false])

@php
    $classes = $active
        ? 'inline-flex items-center px-3 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 border-b-2 border-primary-600'
        : 'inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 border-b-2 border-transparent hover:text-primary-600 dark:hover:text-primary-400 hover:border-primary-500 transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
