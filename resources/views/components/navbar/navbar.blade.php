<nav id="navbar"
    class="sticky top-0 z-50 bg-white/95 backdrop-blur-lg border-b border-gray-200 shadow-sm transition-all duration-300 w-full">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
        <!-- Logo Section -->
        <div class="flex items-center space-x-3">
            <a href="{{ Auth::user()->role == 'admin' ? route('home.admin') : route('home') }}"
                class="flex items-center space-x-2 group transition-all duration-200">
                <div class="p-2 bg-indigo-600 rounded-lg shadow-md group-hover:rotate-12 transition-transform">
                    <i class="ri-calendar-2-line text-xl text-white"></i>
                </div>
                <span
                    class="text-xl font-bold bg-gradient-to-r from-indigo-500 to-indigo-600 bg-clip-text text-transparent">
                    {{ env('APP_NAME') }}
                </span>
            </a>
        </div>

        <!-- Right Controls -->
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
                        class="flex items-center space-x-2 pl-1 pr-2 py-1 rounded-full hover:bg-gray-100 transition-all duration-200 group">
                        <div class="relative">
                            <img src="{{ Auth::user()->profile_picture }}" alt="{{ Auth::user()->name }}"
                                class="w-9 h-9 rounded-full border-2 border-white shadow-sm object-cover">
                            <span
                                class="absolute bottom-0 right-0 block w-2.5 h-2.5 rounded-full bg-green-500 border border-white"></span>
                        </div>
                        <span
                            class="hidden md:inline-block font-medium text-sm text-gray-700 group-hover:text-indigo-600 transition-colors">
                            {{ Auth::user()->name }}
                        </span>
                        <i class="ri-arrow-down-s-line text-gray-500 group-hover:text-indigo-600 transition-colors"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-menu"
                        class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl ring-1 ring-gray-200 overflow-hidden z-50 transition-all duration-200 origin-top-right scale-95 opacity-0">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="#"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="ri-user-line mr-3 text-indigo-500"></i> My Profile
                        </a>
                        <a href="{{ route('orders.customers') }}"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors md:hidden">
                            <i class="ri-shopping-bag-line mr-3 text-indigo-500"></i> My Orders
                        </a>

                        <a href="#"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="ri-settings-3-line mr-3 text-indigo-500"></i> Account Settings
                        </a>
                        <a href="{{ route('logout') }}"
                            class="flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors border-t border-gray-100">
                            <i class="ri-logout-box-r-line mr-3"></i> Sign Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
