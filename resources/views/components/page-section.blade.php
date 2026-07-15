@props(['maxWidth' => 'xl'])

@php
    $maxWidthClass = match ($maxWidth) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-screen-xl',
        default => 'max-w-screen-xl',
    };
@endphp

<div {{ $attributes->merge(['class' => "px-4 py-8 mx-auto {$maxWidthClass}"]) }}>
    {{ $slot }}
</div>
