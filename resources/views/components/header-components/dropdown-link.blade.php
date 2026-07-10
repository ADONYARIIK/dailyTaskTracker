<a
    {{ $attributes->merge([
        'class' =>
            'block w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200',
    ]) }}>
    {{ $slot }}
</a>
