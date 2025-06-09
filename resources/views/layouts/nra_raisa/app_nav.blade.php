<nav class="bg-gradient-to-r from-raisaDongker1 to-raisaDongker2 text-white shadow border-b-2 border-b-sky-700 z-40">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-4">
        <div class="relative flex items-center justify-between h-16">
            <div class="flex items-center">
                <!-- Hamburger menu button -->
                <button type="button" id="sidebar-toggle"
                    class="inline-flex items-center justify-center p-2 text-white hover:text-gray-200 hover:bg-white/10 ">
                    <span class="sr-only">Toggle sidebar</span>
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex-shrink-0 flex items-center ml-4">
                    {{-- <img class="block h-8 w-auto" src="https://via.placeholder.com/50" alt="Logo"> --}}
                    {{-- <div class="inline-block p-2 bg-raisaDongker1 text-white rounded-full">
                        <i class="fas fa-shield-alt text-3xl"></i>
                    </div> --}}
                    <span class="ml-2 text-xl font-semibold"><i class="fas fa-shield-alt"></i> RAISA</span>
                </div>
            </div>
            <div class="flex items-center gap-x-2">
                <!-- Light/Dark mode toggle -->
                <button id="darkModeToggle" class="py-1 px-4 rounded-full hover:text-gray-200 hover:bg-white/10 ">
                    {{-- <i class="fas fa-moon"></i> --}}
                </button>

                <!-- User dropdown -->
                <div class="relative">
                    <button type="button"
                        class="flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-raisaDongker1 focus:ring-white px-2 rounded-full hover:text-gray-200 hover:bg-white/10 "
                        id="user-menu-button">
                        <span class="sr-only">Open user menu</span>
                        {{-- <img class="h-8 w-8" src="https://via.placeholder.com/32" alt="User"> --}}
                        <i class="fas fa-user-circle text-2xl "></i>
                    </button>
                    <div id="user-dropdown"
                        class="hidden absolute right-0 mt-2 w-48 shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 dark:divide-gray-700">{{-- rounded-md --}}
                        <div class="py-1">
                            <a href="{{ route('landing.home') }}"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Landing
                                Page</a>
                        </div>
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                @csrf
                                <button href="#" class="w-full text-left">Logout</button>
                                {{-- <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link> --}}
                            </form>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</nav>
