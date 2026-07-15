@props([
    'category' => null,
    'action',
    'method' => 'POST',
    'submitLabel' => null,
])

<form method="POST" action="{{ $action }}" {{ $attributes->merge(['class' => 'space-y-4 md:space-y-6']) }}>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <x-input.label for="name" :value="__('Name')" />
        <x-input.text-input id="name" type="text" name="name" :value="old('name', $category['name'] ?? null)" required autofocus />
        <x-input.error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="flex sm:flex-row gap-3 justify-between items-center w-full">
        <div>
            <x-input.secondary-button type="button" onclick="window.location='{{ route('categories.index') }}'">
                {{ __('Cancel') }}
            </x-input.secondary-button>
        </div>

        <div>
            <x-input.primary-button :fullWidth="false">
                {{ $submitLabel ?? ($category ? __('Update') : __('Create')) }}
            </x-input.primary-button>
        </div>
    </div>
</form>
