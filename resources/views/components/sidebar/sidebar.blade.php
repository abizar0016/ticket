<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen bg-white shadow-2xl transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:shadow-3xl origin-left flex flex-col justify-between md:-translate-x-0 -translate-x-full">

    <!-- Sidebar Scrollable Content -->
    <div class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 p-4">
        <ul class="space-y-2">
            <!-- Overview Section -->
            <li class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider animate-[fadeIn_0.5s_ease-out_forwards]">
                Overview
                <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent mt-2 animate-[expand_0.8s_cubic-bezier(0.34,1.56,0.64,1)_forwards]"></div>
            </li>

            <li class="animate-[slideIn_0.6s_cubic-bezier(0.34,1.56,0.64,1)_forwards] delay-100">
                <a href="{{ route('event.dashboard', ['id' => $event->id]) }}"
                    class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-all duration-300 group hover:shadow-sm hover:-translate-x-1">
                    <i class="ri-dashboard-line text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Dashboard</span>
                    <div class="ml-auto w-2 h-2 rounded-full bg-primary-400 animate-[pulse_2s_ease-in-out_infinite]"></div>
                </a>
            </li>

            <!-- Manage Section -->
            <li class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider animate-[fadeIn_0.5s_ease-out_forwards] delay-200">
                Manage
                <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent mt-2 animate-[expand_0.8s_cubic-bezier(0.34,1.56,0.64,1)_forwards] delay-300"></div>
            </li>

            <li class="animate-[slideIn_0.6s_cubic-bezier(0.34,1.56,0.64,1)_forwards] delay-300">
                <a href="{{ route('event.settings', ['id' => $event->id]) }}"
                    class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-all duration-300 group hover:shadow-sm hover:-translate-x-1">
                    <i class="ri-settings-3-line text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Settings</span>
                </a>
            </li>

            <li class="animate-[slideIn_0.6s_cubic-bezier(0.34,1.56,0.64,1)_forwards] delay-350">
                <a href="{{ route('event.attendees', ['id' => $event->id]) }}"
                    class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-all duration-300 group hover:shadow-sm hover:-translate-x-1">
                    <i class="ri-group-line text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Attendees</span>
                </a>
            </li>

            <li class="animate-[slideIn_0.6s_cubic-bezier(0.34,1.56,0.64,1)_forwards] delay-400">
                <a href="{{ route('event.orders', ['id' => $event->id]) }}"
                    class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-all duration-300 group hover:shadow-sm hover:-translate-x-1">
                    <i class="ri-shopping-cart-line text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Orders</span>
                </a>
            </li>

            <li class="animate-[slideIn_0.6s_cubic-bezier(0.34,1.56,0.64,1)_forwards] delay-450">
                <a href="{{ route('event.products', ['id' => $event->id]) }}"
                    class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-all duration-300 group hover:shadow-sm hover:-translate-x-1">
                    <i class="ri-ticket-2-line text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Tickets & Products</span>
                </a>
            </li>

            <li class="animate-[slideIn_0.6s_cubic-bezier(0.34,1.56,0.64,1)_forwards] delay-550">
                <a href="{{ route('event.checkins', ['id' => $event->id]) }}"
                    class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-all duration-300 group hover:shadow-sm hover:-translate-x-1">
                    <i class="ri-qr-code-line text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Check-In Lists</span>
                </a>
            </li>

            <li class="animate-[slideIn_0.6s_cubic-bezier(0.34,1.56,0.64,1)_forwards] delay-600">
                <a href="{{ route('event.promocodes', ['id' => $event->id]) }}"
                    class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-all duration-300 group hover:shadow-sm hover:-translate-x-1">
                    <i class="ri-coupon-line text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Promo Codes</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Bottom Action Buttons -->
    <div class="p-4 border-t border-gray-100">
        <div class="flex flex-col items-center justify-center gap-3">
            <a href="{{ route('home.admin') }}"
                class="w-full flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gray-100 hover:bg-gray-50 font-medium transition-all duration-300 shadow group hover:shadow-md hover:-translate-x-1 animate-[slideIn_0.6s_cubic-bezier(0.34,1.56,0.64,1)_forwards]">
                <i class="ri-arrow-go-back-line text-lg group-hover:scale-110 transition-transform"></i>
                Back to Homepage
            </a>
        </div>
    </div>

    <!-- Floating Toggle Button -->
    <div class="absolute -right-5 top-1/2 transform -translate-y-1/2 md:hidden">
        <button id="sidebar-toggle"
            class="p-2 bg-white rounded-full shadow-lg hover:shadow-xl transition-shadow hover:scale-110">
            <i class="ri-arrow-right-s-line text-gray-600"></i>
        </button>
    </div>
</aside>
