<x-layouts.app title="Edit Task">
    <x-page-section maxWidth="md">
        <x-card>
            <h1
                class="text-center text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                {{ __('Edit task') }}
            </h1>

            <x-task-form :task="$task" :categories="$categories" :action="route('tasks.update', ['task' => $task['id']])" method="PUT" :submitLabel="__('Update')" />
        </x-card>
    </x-page-section>
</x-layouts.app>
