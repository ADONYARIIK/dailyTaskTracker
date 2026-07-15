<x-layouts.app title="Edit Category">
    <x-page-section maxWidth="md">
        <x-card>
            <h1
                class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                {{ __('Edit category') }}
            </h1>

            <x-flash-message />

            <x-category-form :category="$category" :action="route('categories.update', ['category' => $category['id']])" method="PUT" :submitLabel="__('Update')" />
        </x-card>
    </x-page-section>
</x-layouts.app>
