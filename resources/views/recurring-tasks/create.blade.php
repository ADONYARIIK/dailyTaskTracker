<x-layouts.app title="Create Recurring Task">
    <x-page-section maxWidth="md">
        <x-card>
            <h1
                class="text-center text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                {{ __('Create recurring task') }}
            </h1>

            <x-recurring-task-form :categories="$categories" :action="route('recurring-tasks.store')" :submitLabel="__('Create')" :afterSubmitLabel="__('Creating...')" />
        </x-card>
    </x-page-section>
</x-layouts.app>
