<x-layouts.guest title="Forgot Password">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1
                    class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    {{ __('Reset Password') }}
                </h1>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <x-input.label for="email" :value="__('Email')" />
                        <x-input.text-input id="email" type="email" name="email" :value="old('email')" required
                            autofocus />
                        <x-input.error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <x-input.primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-input.primary-button>

                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        {{ __('Remember your password?') }} <a href="{{ route('login') }}"
                            class="underline text-sm text-primary-600 dark:text-primary-500 hover:text-primary-900 dark:hover:text-primary-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Log In') }}</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-layouts.guest>
