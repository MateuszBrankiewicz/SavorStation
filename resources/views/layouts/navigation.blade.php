<nav x-data="{ open: false }" class="bg-opacity-30 rounded-md bg-gradient backdrop-filter backdrop-blur-sm">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center w-1/12 shrink-0">
                    <a href="{{ route('dashboard') }} w-full">
                        <x-nav-link-logo class="block w-full text-gray-800 fill-current dark:text-orange-400" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 md:flex md:-my-px md:ms-10">
                    <x-nav-link :href="route('recipes.create')" :active="request()->routeIs('recipe.create')">
                        {{ __('Dodaj Przepis') }}
                    </x-nav-link>
                    <x-nav-link :href="route('recipes.index')" :active="request()->routeIs('recipes.index')">
                        {{ __('Przepisy') }}
                    </x-nav-link>
                    <x-nav-link :href="route('get.favorites',['id'=>Auth::user()->id])" :active="request()->routeIs('get.favorites')">{{__('Ulubione')}}</x-nav-link>
                    <x-nav-link :href="route('get.userRecipes',['id'=>Auth::user()->id])" :active="request()->routeIs('get.userRecipes')">{{__('Moje Przepisy')}}</x-nav-link>
                    
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center py-2 px-3 text-sm font-medium leading-4 text-gray-500 bg-white rounded-md border border-transparent transition duration-150 ease-in-out dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 focus:outline-none dark:hover:text-gray-300">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center md:hidden -me-2">
                <button @click="open = ! open"
                    class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out dark:text-gray-500 hover:text-gray-500 hover:bg-gray-100 focus:text-gray-500 focus:bg-gray-100 focus:outline-none dark:hover:text-gray-400 dark:hover:bg-gray-900 dark:focus:bg-gray-900 dark:focus:text-gray-400">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('recipes.index')" :active="request()->routeIs('recipes')">
                        {{ __('Przepisy') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('get.favorites',['id'=>Auth::user()->id])" :active="request()->routeIs('get.favorites')">{{__('Ulubione')}}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('get.userRecipes',['id'=>Auth::user()->id])" :active="request()->routeIs('get.userRecipes')">{{__('Twoje Przepisy')}}</x-responsive-nav-link>
                    
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
