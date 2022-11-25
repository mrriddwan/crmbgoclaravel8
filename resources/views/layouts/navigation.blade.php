<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    {{-- <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a> --}}
                </div>

                <!-- Navigation Links -->
                @can('view contact')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                        <x-dropdown align="right" width="w-max">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Contact') }} </div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content" class="w-full">
                                <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('contact')" :active="request()->routeIs('contact')">
                                    {{ __('List') }}
                                </x-nav-link>
                                <br>
                                @can('view contact summary')
                                <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('contact-summary')" :active="request()->routeIs('contact-summary')">
                                    {{ __('Summary') }}
                                </x-nav-link>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
                @endcan

                @can('view todo')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link class="w-full" :href="route('todo')" :active="request()->routeIs('todo')">
                        {{ __('To Do') }}
                    </x-nav-link>
                </div>
                @endcan

                @can('view followup')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link class="w-full" :href="route('followup')" :active="request()->routeIs('followup')">
                        {{ __('Follow Up') }}
                    </x-nav-link>
                </div>
                @endcan

                @can('view forecast')
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                            <x-dropdown align="right" width="w-max">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>{{ __('Forecast') }} </div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content" class="">
                                    <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('forecast')" :active="request()->routeIs('forecast')">
                                        {{ __('List') }}
                                    </x-nav-link>
                                    <br>
                                    @can('view forecast summary')
                                    <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('forecast-summary')" :active="request()->routeIs('forecast-summary')">
                                        {{ __('Summary') }}
                                    </x-nav-link>
                                    @endcan
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @endcan

                @can('view project')
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link class="w-full"  :href="route('project')" :active="request()->routeIs('project')">
                            {{ __('Project') }}
                        </x-nav-link>
                    </div>
                @endcan

                @can('view performance')
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link class="w-full"  :href="route('performance')" :active="request()->routeIs('performance')">
                            {{ __('Performance') }}
                        </x-nav-link>
                    </div>
                @endcan

                @can('view billboard/tempboard')
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                            <x-dropdown align="right" width="w-max">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>{{ __('BB / TP') }} </div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content" class="">
                                    <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('billboard')" :active="request()->routeIs('billboard')">
                                        {{ __('Billboard') }}
                                    </x-nav-link>
                                    <br>
                                    <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('tempboard')" :active="request()->routeIs('tempboard')">
                                        {{ __('Tempboard') }}
                                    </x-nav-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @endcan

                @can('view tracking')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                        <x-dropdown align="right" width="w-max">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Tracking') }} </div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content" class="w-full">
                                @can('view tracking general')
                                <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('tracking-general')" :active="request()->routeIs('tracking-general')" >
                                    {{ __('General') }}
                                </x-nav-link>
                                @endcan
                                <br>
                                @can('view tracking tguide')
                                <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('tracking-travel_guide')" :active="request()->routeIs('tracking-travel_guide')">
                                    {{ __('Travel Guide') }}
                                </x-nav-link>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
                @endcan

                @can('view admin')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                        <x-dropdown align="right" width="w-max">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Admin') }} </div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content" class="">
                                <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('admin-data')" :active="request()->routeIs('admin-data')">
                                    {{ __('Data') }}
                                </x-nav-link>
                                <br>
                                <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('admin-management')" :active="request()->routeIs('admin-management')">
                                    {{ __('User Management') }}
                                </x-nav-link>
                                <br>
                                <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('admin-access')" :active="request()->routeIs('admin-access')">
                                    {{ __('User Access') }}
                                </x-nav-link>
                                <br>
                                <x-nav-link class="w-full hover:bg-blue-300 hover:font-bold" :href="route('admin-export')" :active="request()->routeIs('admin-export')">
                                    {{ __('Export/Import') }}
                                </x-nav-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
            @endcan

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
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
            <div class="-mr-2 flex items-center sm:hidden">
                <button x-on:click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path x-bind:class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-bind:class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-bind:class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            {{-- <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link> --}}

            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                {{ __('Contact') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('todo')" :active="request()->routeIs('todo')">
                {{ __('To Do') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('followup')" :active="request()->routeIs('followup')">
                {{ __('Follow Up') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('forecast')" :active="request()->routeIs('forecast')">
                {{ __('Forecast') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('project')" :active="request()->routeIs('project')">
                {{ __('Project') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('performance')" :active="request()->routeIs('performance')">
                {{ __('Performance') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('billboard')" :active="request()->routeIs('billboard')">
                {{ __('Billboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin-data')" :active="request()->routeIs('admin-data')">
                {{ __('Admin') }}
            </x-responsive-nav-link>

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
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
