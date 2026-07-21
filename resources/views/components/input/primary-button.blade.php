@props(['fullWidth' => true])

<button
    {{ $attributes->merge(['type' => 'submit', 'class' => ($fullWidth ? 'w-full ' : 'inline-flex items-center justify-center ') . 'text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
