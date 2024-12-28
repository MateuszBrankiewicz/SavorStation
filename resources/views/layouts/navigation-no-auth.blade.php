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

                <div class="hidden md:justify-center md:grow space-x-8 md:flex md:-my-px md:ms-10">
                    <x-nav-link :href="route('recipes.index')">{{__('Przepisy')}}</x-nav-link>
                    
                    <x-nav-link :href="route('register')">
                        {{ __('Zarejestruj') }}
                    </x-nav-link>
                    <x-nav-link :href="route('login')">
                        {{ __('Zaloguj') }}
                    </x-nav-link>


                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-6">

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
            <x-responsive-nav-link :href="route('login')">
                {{ __('Zaloguj') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">
                {{ __('Zarejestruj') }}
            </x-responsive-nav-link>

            
        </div>

        <!-- Responsive Settings Options -->

    </div>
</nav>