@props(['message' => null, 'type' => 'success'])

@php
    $message = $message ?? session('success') ?? session('status');

    $classes = match ($type) {
        'error' => 'text-red-600 dark:text-red-400',
        default => 'text-green-600 dark:text-green-400',
    };
@endphp

@if ($message)
    <div {{ $attributes->merge(['class' => "font-medium text-sm text-center {$classes}"]) }}>
        {{ $message }}
    </div>
@endif
