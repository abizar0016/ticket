<nav id="navbar" class="sticky top-0 z-50 flex justify-between w-full bg-white dark:bg-gray-900 py-4 px-6 shadow-sm">
    <!-- Logo Section -->
    <div class="flex items-center space-x-3">
        <a href="{{ Auth::user()->role == 'admin' ? route('home.admin') : route('home.customer') }}"
            class="flex items-center space-x-2 group transition-all duration-200">
            <div
                class="w-12 h-12 bg-indigo-600 flex justify-center items-center rounded-lg shadow-md group-hover:rotate-12 transition-transform">
                <i class="ri-calendar-2-line text-2xl text-white"></i>
            </div>
            <span
                class="text-xl font-bold bg-gradient-to-r from-indigo-500 to-indigo-600 dark:from-indigo-100 dark:to-indigo-200 bg-clip-text text-transparent">
                {{ env('APP_NAME') }}
            </span>
        </a>
    </div>

    <div class="flex items-center space-x-5">

        <!-- Icons Group -->
        <div class="flex items-center space-x-4">
            <!-- Orders Link (Only for Customers) -->
            @if (Auth::user()->role == 'customer')
                <a href="{{ route('orders.customers') }}"
                    class="hidden md:flex items-center space-x-1 px-3 py-2 rounded-lg hover:bg-gray-100 transition-all duration-200 group"
                    title="My Orders">
                    <i class="ri-shopping-bag-line text-gray-600 group-hover:text-indigo-600"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600">My Orders</span>
                </a>
            @endif

            <!-- User Profile -->
            <div class="relative ml-2">
                <button id="user-menu-button"
                    class="flex items-center space-x-2 pl-1 pr-2 py-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer transition-all duration-200 group">
                    <div class="relative">
                        @if (!empty(Auth::user()->profile_picture))
                            <img src="{{ Auth::user()->profile_picture }}" alt="{{ Auth::user()->name }}"
                                class="w-9 h-9 rounded-full border-2 border-white shadow-sm object-cover">
                        @else
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 flex items-center justify-center text-white font-medium text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                                {{ substr(strstr(Auth::user()->name, ' '), 1, 1) ?? '' }}
                            </div>
                        @endif

                        <span
                            class="absolute bottom-0 right-0 block w-2.5 h-2.5 rounded-full bg-green-500 border border-white"></span>
                    </div>
                    <span
                        class="hidden md:inline-block font-medium text-sm text-gray-700 dark:text-indigo-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-300 transition-colors">
                        {{ Auth::user()->name }}
                    </span>
                    <i
                        class="ri-arrow-down-s-line text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-300 transition-colors"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="user-menu"
                    class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl ring-1 ring-gray-200 dark:ring-gray-700 overflow-hidden z-50 transition-all duration-200 origin-top-right scale-95 opacity-0">
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>

                    @if (Auth::user()->role == 'customer')
                        <a href="{{ route('orders.customers') }}"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-950 transition-colors md:hidden">
                            <i class="ri-shopping-bag-line mr-3 text-indigo-500"></i> My Orders
                        </a>
                    @endif

                    <a href="{{ route('logout') }}"
                        class="flex items-center gap-2 px-4 py-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-700/30 rounded-lg transition">
                        <i class="ri-logout-circle-r-line"></i> Logout
                    </a>

                </div>
            </div>
        </div>
    </div>
</nav>
