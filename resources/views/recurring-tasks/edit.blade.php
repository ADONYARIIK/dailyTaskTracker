<x-layouts.app title="Edit Recurring Task">
    <x-page-section maxWidth="md">
        <x-card>
            <h1
                class="text-center text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                {{ __('Edit recurring task') }}
            </h1>

            <x-recurring-task-form :recurringTask="$recurringTask" :categories="$categories"
                :action="route('recurring-tasks.update', ['recurring_task' => $recurringTask['id']])" method="PUT"
                :submitLabel="__('Update')" />
        </x-card>
    </x-page-section>
</x-layouts.app>
