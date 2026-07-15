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
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($categories as $category)
                        <li class="flex flex-col gap-3 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-base font-medium text-gray-900 dark:text-white">
                                    {{ $category['name'] }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Created') }}: {{ $category['created_at']?->format('M d, Y g:i A') ?? '-' }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Updated') }}: {{ $category['updated_at']?->format('M d, Y g:i A') ?? '-' }}
                                </p>
                            </div>

                            <div class="flex flex-wrap items-center gap-5">
                                <a href="{{ route('categories.edit', ['category' => $category['id']]) }}"
                                    class="inline-flex items-center justify-center text-primary-600 bg-primary-50 hover:bg-primary-100 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-base px-4 py-2 dark:bg-primary-900/30 dark:text-primary-400 dark:hover:bg-primary-900/50 dark:focus:ring-primary-800">
                                    {{ __('Edit') }}
                                </a>

                                <form method="POST"
                                    action="{{ route('categories.destroy', ['category' => $category['id']]) }}"
                                    onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <x-input.danger-button>
                                        {{ __('Delete') }}
                                    </x-input.danger-button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="pt-4">
                    {{ $links() }}
                </div>
            @endif
        </x-card>
    </x-page-section>
</x-layouts.app>
