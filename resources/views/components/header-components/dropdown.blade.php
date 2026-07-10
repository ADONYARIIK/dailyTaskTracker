@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-2 bg-white dark:bg-gray-700',
])

@php
    $alignmentClasses = match ($align) {
        'left' => 'start-0 origin-top-left',
        'top' => 'origin-top',
        default => 'end-0 origin-top-right',
    };

    $width = match ($width) {
        '48' => 'w-48',
        default => $width,
    };
@endphp

<div x-data="{ open: false }" class="relative" @click.outside="open = false">

    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div x-show="open" x-transition style="display:none"
        class="absolute z-50 mt-2 {{ $width }} {{ $alignmentClasses }}">
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-700 shadow-lg border border-gray-200 dark:border-gray-600"
            @click="open = false">
            {{ $content }}
        </div>
    </div>

</div>
