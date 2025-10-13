<!-- Toggle Button (Mobile Only) -->
<button id="sidebarToggle"
    class="fixed left-0 top-1/2 -translate-y-1/2 z-50 flex items-center justify-center
           w-10 h-16 bg-indigo-600 text-white rounded-r-xl shadow-lg md:hidden transition-all duration-300">
    <i id="sidebarToggleIcon" class="ri-arrow-right-s-line text-2xl"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed left-0 top-20 flex h-[calc(100vh-5rem)] w-80 flex-col gap-6 overflow-y-auto
           bg-white px-6 py-4 transition-all duration-300 md:translate-x-0 -translate-x-full
           dark:bg-gray-900 shadow-2xl shadow-black/25 border-r border-gray-100/80 dark:border-gray-800 z-40">

    <div class="flex flex-col flex-1 no-scrollbar">
        <nav class="flex-1">

            {{-- ==== MAIN MENU SUPERADMIN ==== --}}
            @if (Auth::user()->role == 'superadmin')
                <div class="mb-8">
                    <h3
                        class="mb-4 text-xs font-semibold uppercase tracking-widest text-gray-500/90 dark:text-gray-400/80 pl-2">
                        MAIN MENU
                    </h3>
                    <ul class="flex flex-col gap-2 mb-6">
                        <li>
                            <a href="{{ route('superAdmin.dashboard') }}"
                                class="menu-item group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300
                                       text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 
                                       dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                <i class="ri-dashboard-3-line text-xl relative z-10"></i>
                                <span class="ml-3 font-medium">Dashboard</span>
                            </a>
                        </li>

                        <!-- Events -->
                        <li>
                            <div class="menu-item cursor-pointer group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300"
                                data-submenu="events">
                                <i class="ri-calendar-event-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Events</span>
                                <i class="ri-arrow-down-s-line ml-auto transition-transform duration-300 submenu-icon relative z-10"
                                    data-submenu="events"></i>
                            </div>

                            <div class="overflow-hidden transition-all duration-500 transform submenu-content mt-2"
                                data-submenu="events" style="max-height:0">
                                <ul class="flex flex-col gap-1.5 menu-dropdown pl-14 py-2">
                                    <li>
                                        <a href="{{ route('superAdmin.events') }}"
                                            class="menu-dropdown-item group flex items-center gap-3 py-2.5 px-4 text-sm rounded-lg transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                            <i class="ri-list-unordered text-base"></i> Events
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('superAdmin.events.categories') }}"
                                            class="menu-dropdown-item group flex items-center gap-3 py-2.5 px-4 text-sm rounded-lg transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                            <i class="ri-price-tag-3-line text-base"></i> Event Categories
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Orders -->
                        <li>
                            <div class="menu-item cursor-pointer group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300"
                                data-submenu="orders">
                                <i class="ri-shopping-bag-3-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Orders</span>
                                <i class="ri-arrow-down-s-line ml-auto transition-transform duration-300 submenu-icon relative z-10"
                                    data-submenu="orders"></i>
                            </div>

                            <div class="overflow-hidden transition-all duration-500 transform submenu-content mt-2"
                                data-submenu="orders" style="max-height:0">
                                <ul class="flex flex-col gap-1.5 menu-dropdown pl-14 py-2">
                                    <li>
                                        <a href="{{ route('superAdmin.orders') }}"
                                            class="menu-dropdown-item group flex items-center gap-3 py-2.5 px-4 text-sm rounded-lg transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                            <i class="ri-file-list-3-line text-base"></i> All Orders
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('superAdmin.revenue-reports') }}"
                                            class="menu-dropdown-item group flex items-center gap-3 py-2.5 px-4 text-sm rounded-lg transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                            <i class="ri-bar-chart-2-line text-base"></i> Revenue Report
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Users -->
                        <li>
                            <div class="menu-item cursor-pointer group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300"
                                data-submenu="users">
                                <i class="ri-user-settings-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Users</span>
                                <i class="ri-arrow-down-s-line ml-auto transition-transform duration-300 submenu-icon relative z-10"
                                    data-submenu="users"></i>
                            </div>

                            <div class="overflow-hidden transition-all duration-500 transform submenu-content mt-2"
                                data-submenu="users" style="max-height:0">
                                <ul class="flex flex-col gap-1.5 menu-dropdown pl-14 py-2">
                                    <li>
                                        <a href="{{ route('superAdmin.users') }}"
                                            class="menu-dropdown-item group flex items-center gap-3 py-2.5 px-4 text-sm rounded-lg transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                            <i class="ri-user-line text-base"></i> All Users
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('superAdmin.organizations') }}"
                                            class="menu-dropdown-item group flex items-center gap-3 py-2.5 px-4 text-sm rounded-lg transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                            <i class="ri-user-star-line text-base"></i> Organization
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Reports -->
                        <li>
                            <a href="{{ route('superAdmin.customers-reports') }}"
                                class="menu-item group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                <i class="ri-message-2-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Customers Reports</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('superAdmin.activities') }}"
                                class="menu-item group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                <i class="ri-history-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Log Activity</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif

            <!-- EVENTS -->
            @if (isset($eventId) && isset($events))
                <div class="mb-8">
                    <h3
                        class="mb-4 text-xs font-semibold uppercase tracking-widest text-gray-500/90 dark:text-gray-400/80 pl-2">
                        {{ $events->title }}
                    </h3>
                    <ul class="flex flex-col gap-2 mb-6">
                        <li>
                            <a href="{{ route(Auth::user()->role == 'superadmin' ? 'superAdmin.events.dashboard' : 'admin.events.dashboard', $eventId) }}"
                                class="menu-item group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                <i class="ri-dashboard-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Event Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(Auth::user()->role == 'superadmin' ? 'superAdmin.events.settings' : 'admin.events.settings', $eventId) }}"
                                class="menu-item group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                <i class="ri-settings-3-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(Auth::user()->role == 'superadmin' ? 'superAdmin.events.attendees' : 'admin.events.attendees', $eventId) }}"
                                class="menu-item group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                <i class="ri-group-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Attendees</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(Auth::user()->role == 'superadmin' ? 'superAdmin.events.orders' : 'admin.events.orders', $eventId) }}"
                                class="menu-item group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                <i class="ri-shopping-bag-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(Auth::user()->role == 'superadmin' ? 'superAdmin.events.products' : 'admin.events.products', $eventId) }}"
                                class="menu-item group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                <i class="ri-ticket-2-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Tickets & Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(Auth::user()->role == 'superadmin' ? 'superAdmin.events.checkins' : 'admin.events.checkins', $eventId) }}"
                                class="menu-item group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                <i class="ri-qr-code-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Check-In Lists</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(Auth::user()->role == 'superadmin' ? 'superAdmin.events.promos' : 'admin.events.promos', $eventId) }}"
                                class="menu-item group relative flex items-center py-3 px-4 rounded-xl transition-all duration-300 text-gray-800 hover:bg-indigo-100 hover:shadow-md hover:shadow-gray-300 dark:hover:bg-gray-800 dark:text-indigo-100 dark:shadow-indigo-300">
                                <i class="ri-coupon-line text-xl relative z-10"></i>
                                <span class="menu-item-text font-medium relative z-10 ml-3">Promo</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </nav>
    </div>

    @if (Auth::user()->role == 'admin')
        <!-- Bottom Action Buttons -->
        <div class="p-4 border-gray-100 bg-white dark:bg-gray-900">
            <div class="flex flex-col items-center justify-center gap-3">
                <a href="{{ route('admin.index') }}"
                    class="w-full flex items-center justify-center gap-2 p-3 rounded-xl text-indigo-600 dark:text-indigo-100 bg-gray-100 dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-all duration-300 shadow group hover:shadow-md hover:-translate-y-1 animate-[slideIn_0.6s_cubic-bezier(0.34,1.56,0.64,1)_forwards]">
                    <i class="ri-arrow-go-back-line text-lg group-hover:scale-110 transition-transform"></i>
                    Back to Homepage
                </a>
            </div>
        </div>
    @endif

</aside>
