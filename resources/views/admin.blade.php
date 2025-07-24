<!doctype html>
<html lang="en">

@include('components.head.head')

<body class="bg-gray-50 text-gray-800 font-inter antialiased">
    <!-- Preloader -->
    @include('components.preloader.preloader')

    <!-- Navbar -->
    @include('components.navbar.navbar')

    <div class="min-h-screen p-6">
        <!-- Animated Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Events -->
            <div
                class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium opacity-90">Total Events</p>
                        <h3 class="text-3xl font-bold mt-2 animate-count">{{ $eventsCount }}</h3>
                    </div>
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                        <i class="ri-calendar-event-line text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Active Events -->
            <div
                class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite] delay-100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium opacity-90">Active Events</p>
                        <h3 class="text-3xl font-bold mt-2 animate-count">{{ $ongoingCount }}</h3>
                    </div>
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                        <i class="ri-flashlight-line text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div
                class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite] delay-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium opacity-90">Upcoming</p>
                        <h3 class="text-3xl font-bold mt-2 animate-count">{{ $upcomingCount }}</h3>
                    </div>
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                        <i class="ri-time-line text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Ended Events -->
            <div
                class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite] delay-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium opacity-90">Ended Events</p>
                        <h3 class="text-3xl font-bold mt-2 animate-count">{{ $endedCount }}</h3>
                    </div>
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                        <i class="ri-checkbox-circle-line text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header Section -->
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 animate-[slideUp_0.8s_ease-out_forwards]">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <i class="ri-calendar-event-line text-indigo-500 animate-[pulse_2s_ease-in-out_infinite]"></i>
                    Events Summary
                </h1>
                <p class="text-gray-500 mt-2">Manage your events and organizers</p>
            </div>

            <!-- Create Button with Dropdown -->
            <div class="relative">
                <button id="dropdownCreateButton"
                    class="flex items-center gap-2 text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-xl text-sm px-5 py-3 text-center shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <i class="ri-add-line"></i>
                    Create new
                    <i class="ri-arrow-down-s-line w-4 h-4 transition-transform duration-300" id="dropdownArrow"></i>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdownCreate"
                    class="z-20 hidden bg-white divide-y divide-gray-100 rounded-xl shadow-xl w-44 absolute right-0 mt-2 border border-gray-100 transition-all duration-200 origin-top-right opacity-0 scale-95">
                    <ul class="py-2 text-sm text-gray-700">
                        <li>
                            <a href="#" id="openEventModal"
                                class="flex items-center px-4 py-2 hover:bg-gray-50 transition-all duration-200 hover:translate-x-1">
                                <i class="ri-calendar-event-line mr-2 text-indigo-500"></i>
                                <span>Event</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="openOrganizerModal"
                                class="flex items-center px-4 py-2 hover:bg-gray-50 transition-all duration-200 hover:translate-x-1">
                                <i class="ri-user-add-line mr-2 text-indigo-500"></i>
                                <span>Organizer</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Filter and Search Section -->
        <div
            class="bg-white rounded-2xl shadow-xl p-6 mb-8 transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 animate-[slideUp_0.8s_ease-out_forwards] delay-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <!-- Status Filter Buttons -->
                <div class="flex flex-wrap gap-3">
                    <!-- All Button -->
                    <a href="{{ route('home.admin') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl focus:z-10 focus:ring-2 focus:ring-indigo-500 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5             
                    {{ $currentFilter === null
                        ? 'text-white bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700'
                        : 'text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 hover:text-indigo-700' }}">
                        All
                    </a>

                    <!-- Upcoming Button -->
                    <a href="{{ route('status', ['status' => 'upcoming']) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl focus:z-10 focus:ring-2 focus:ring-indigo-500 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 
                    {{ $currentFilter === 'upcoming'
                        ? 'text-white bg-gradient-to-r from-blue-400 to-blue-600 hover:from-blue-500 hover:to-blue-00 transition-all duration-300'
                        : 'text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 hover:text-indigo-700' }}">
                        Upcoming
                    </a>

                    <!-- Active Button -->
                    <a href="{{ route('status', ['status' => 'ongoing']) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl focus:z-10 focus:ring-2 focus:ring-indigo-500 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 
                    {{ $currentFilter === 'ongoing'
                        ? 'text-white bg-gradient-to-r from-emerald-400 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300'
                        : 'text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 hover:text-indigo-700' }}">
                        Ongoing
                    </a>

                    <!-- Ended Button -->
                    <a href="{{ route('status', ['status' => 'ended']) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl focus:z-10 focus:ring-2 focus:ring-indigo-500 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 
                    {{ $currentFilter === 'ended'
                        ? 'text-white bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700
                        transition-all duration-300'
                        : 'text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 hover:text-indigo-700' }}">
                        Ended
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden lg:block relative w-72 transition-all hover:-translate-y-0.5">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="ri-search-line"></i>
                    </div>
                    <input type="search"
                        class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white/50 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:shadow-sm"
                        placeholder="Search events by name...">
                </div>
            </div>
        </div>

        <!-- Event Cards Grid -->
        @include('components.event-card.card', ['events' => $events])

        <!-- Pagination -->
        <div class="mt-8 animate-[fadeIn_0.8s_ease-out_forwards] delay-200">
            {{ $events->links('pagination::default') }}
        </div>
    </div>

    <!-- Event Modal -->
    @include('components.modal.create-event')

    <!-- Organizer Modal -->
    @include('components.modal.create-organizer')

</body>

</html>
