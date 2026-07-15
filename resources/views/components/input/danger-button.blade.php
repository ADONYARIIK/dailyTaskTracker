<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 cursor-pointer']) }}>
    {{ $slot }}
</button>
