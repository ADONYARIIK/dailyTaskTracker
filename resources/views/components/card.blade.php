<div {{ $attributes->merge(['class' => 'w-full bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700']) }}>
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        {{ $slot }}
    </div>
</div>
