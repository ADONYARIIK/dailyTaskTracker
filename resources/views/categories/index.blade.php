<x-layouts.app title="Categories">
    <x-page-section>
        <x-card>
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    {{ __('Categories') }}
                </h1>

                <a href="{{ route('categories.create') }}"
                    class="inline-flex items-center justify-center text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    {{ __('Create category') }}
                </a>
            </div>

            <x-flash-message class="mt-4" />

            @if (!$categories)
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    {{ __('No categories yet. Create your first one to get started.') }}
                </p>
            @else
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">{{ __('Category') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Created') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Updated') }}</th>
                            <th scope="col" class="px-6 py-3"><span class="sr-only">{{ __('Actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr data-category-item
                                class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $category['name'] }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">{{ $category['created_at']['display'] }}</td>
                                <td class="px-6 py-4">{{ $category['updated_at']['display'] }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <a href="{{ route('categories.edit', ['category' => $category['id']]) }}"
                                            class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-400">
                                            {{ __('Edit') }}
                                        </a>
                                        <button type="button" data-category-delete data-id="{{ $category['id'] }}"
                                            class="cursor-pointer text-sm font-medium text-red-600 hover:underline dark:text-red-400">
                                            {{ __('Delete') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td colspan="5" class="px-6 py-8 text-center text-sm">
                                    {{ __('No recurring tasks found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pt-4">
                    {{ $links() }}
                </div>
            @endif
        </x-card>
    </x-page-section>
    @push('scripts')
        @vite('resources/js/pages/categories-index.js')
    @endpush
</x-layouts.app>
