<x-layouts.guest title="Reset Password">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1
                    class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    {{ __('Change your password') }}
                </h1>
                <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('password.store') }}">
        @csrf

        {{-- Password Reset Token --}}
        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Email --}}
        <div>
            <x-input.label for="email" :value="__('Email')" />
            <x-input.text-input id="email" type="email" name="email" :value="old('email', $email)" required
                autocomplete="username" />
            <x-input.error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input.label for="password" :value="__('Password')" />
            <x-input.text-input id="password" type="password" name="password" required autofocus
                autocomplete="new-password" />
            <x-input.error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="mt-4">
            <x-input.label for="password_confirmation" :value="__('Confirm Password')" />

            <x-input.text-input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" />

            <x-input.error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-input.primary-button>
            {{ __('Reset Password') }}
        </x-input.primary-button>
    </form>
</x-layouts.guest>
