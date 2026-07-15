<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4 lg:px-6 py-2.5">
        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <img src="{{ asset('assets/logo.png') }}" class="h-8 mr-3 saturate-700" alt="Logo">
        </a>
        {{-- Desktop Navigation --}}
        <div class="hidden md:flex items-center gap-20">
            <x-header-components.nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-header-components.nav-link>
            <x-header-components.nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')">
                {{ __('Tasks') }}
            </x-header-components.nav-link>
            <x-header-components.nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                {{ __('Categories') }}
            </x-header-components.nav-link>
        </div>
        {{-- Right Side --}}
        <div class="flex items-center gap-3">
            {{-- User Dropdown --}}
            <div class="hidden md:block">
                <x-header-components.dropdown align="right">
                    <x-slot name="trigger">
                        <button type="button"
                            class="flex items-center rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 cursor-pointer">
                            <img src="{{ asset('assets/guestUser.png') }}" alt="User"
                                class="w-10 h-10 rounded-full object-cover dark:invert">
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                        {{-- <x-header-components.dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-user mr-2 w-4"></i> {{ __('Profile') }}
                        </x-header-components.dropdown-link> --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-header-components.dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fa-solid fa-right-from-bracket mr-2 w-4"></i> {{ __('Log Out') }}
                            </x-header-components.dropdown-link>
                        </form>
                    </x-slot>
                </x-header-components.dropdown>
            </div>
            {{-- Mobile button --}}
            <button @click="open = !open"
                class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-primary-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    {{-- Mobile Menu --}}
    <div x-show="open" x-transition
        class="md:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="px-4 py-4 space-y-2">
            <x-header-components.responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-header-components.responsive-nav-link>
            <x-header-components.responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                {{ __('Categories') }}
            </x-header-components.responsive-nav-link>
            <x-header-components.responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                {{ __('Tasks') }}
            </x-header-components.responsive-nav-link>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('assets/guestUser.png') }}" class="w-10 h-10 rounded-full object-cover dark:invert"
                    alt="User">
                <div>
                    <div class="font-semibold text-gray-900 dark:text-white">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ Auth::user()->email }}
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                {{-- <x-header-components.responsive-nav-link :href="route('profile.edit')">
                    <i class="fa-solid fa-user mr-2"></i> {{ __('Profile') }}
                </x-header-components.responsive-nav-link> --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-header-components.responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i> {{ __('Log Out') }}
                    </x-header-components.responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
