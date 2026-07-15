<x-layouts.app title="Create Category">
    <x-page-section maxWidth="md">
        <x-card>
            <h1
                class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                {{ __('Create category') }}
            </h1>

            <x-flash-message />

            <x-category-form :action="route('categories.store')" :submitLabel="__('Create')" />
        </x-card>
    </x-page-section>
</x-layouts.app>
