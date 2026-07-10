<x-layouts.guest title="LogIn">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1
                    class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    {{ __('Sign in to your account') }}
                </h1>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('login.post') }}">
                    @csrf
                    {{-- Email --}}
                    <div>
                        <x-input.label for="email" :value="__('Email')" />
                        <x-input.text-input id="email" type="email" name="email" :value="old('email')" required
                            autofocus autocomplete="username" />
                        <x-input.error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    {{-- Password --}}
                    <div class="mt-4">
                        <x-input.label for="password" :value="__('Password')" />
                        <x-input.text-input id="password" type="password" name="password" required
                            autocomplete="current-password" />
                        <x-input.error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex justify-between mt-4 mb-3">
                        {{-- Remember Me --}}
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <x-input.checkbox-input id="remember" name="remember" aria-describedby="remember" />

                            </div>
                            <div class="ml-3 text-sm">
                                <x-input.label for="remember" :value="__('Remember me')" />
                            </div>
                        </div>
                        {{-- Forgot Password --}}
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-primary-600 dark:text-primary-500 hover:text-primary-900 dark:hover:text-primary-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                    <x-input.primary-button>
                        {{ __('Log in') }}
                    </x-input.primary-button>
                    <x-input.error :messages="$errors->get('attempt')" class="mt-2" />
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        {{ __('Don’t have an account yet?') }} <a href="{{ route('register') }}"
                            class="underline text-sm text-primary-600 dark:text-primary-500 hover:text-primary-900 dark:hover:text-primary-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Register') }}</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-layouts.guest>
