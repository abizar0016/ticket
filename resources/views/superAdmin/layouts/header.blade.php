<header class="sticky top-0 z-50 flex w-full bg-white dark:bg-gray-900 py-4 px-6 shadow-sm">
    <div class="flex w-full items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="index.html" class="flex items-center gap-3 transition-all duration-300 hover:scale-[1.02]">
                    <div
                        class="flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600">
                        <i class="ri-dashboard-3-line text-2xl text-white"></i>
                    </div>
                    <div class="md:flex hidden">
                        <span class="text-xl font-bold text-gray-800 dark:text-white">
                            DashBoard
                        </span>
                    </div>
                </a>
            </div>
            <button id="sidebarSuperAdminToggle"
                class="flex md:hidden h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-500 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ri-menu-2-line text-md"></i>
            </button>

            <div class="relative hidden md:block w-72">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="search" placeholder="Search or type command..."
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-12 h-12 text-sm text-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" />
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button
                class="relative h-10 w-10 flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ri-notification-3-line text-lg text-gray-600 dark:text-gray-300"></i>
                <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-orange-400"></span>
            </button>

            <div class="relative">
                <div id="superAdminMenuButton" class="flex items-center gap-2 cursor-pointer select-none">
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
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200 hidden sm:block">
                        {{ $user->name }}
                    </span>
                    <i class="ri-arrow-down-s-line text-gray-400"></i>
                </div>

                <div id="superAdminMenu"
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 hidden">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        <li>
                            <a href="#"
                                class="flex items-center gap-2 px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition">
                                <i class="ri-user-line"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center gap-2 px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition">
                                <i class="ri-settings-3-line"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                class="flex items-center gap-2 px-4 py-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-700/30 rounded-lg transition">
                                <i class="ri-logout-circle-r-line"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="z-40 bg-white dark:bg-gray-900 py-3 px-6 border-b border-gray-200 dark:border-gray-800 md:hidden">
    <div class="relative">
        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input type="search" placeholder="Search or type command..."
            class="w-full rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-12 h-12 text-sm text-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" />
    </div>
</div>
