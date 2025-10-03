<!-- Stat Cards -->
<section class="px-4 sm:px-6 lg:px-8 py-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 sm:gap-6">
        <div class="rounded-2xl p-6 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs sm:text-sm text-indigo-100">Total Users</p>
                    <h2 class="text-xl sm:text-2xl font-bold">{{ number_format($totalUsers) }}</h2>
                </div>
                <i class="ri-user-3-line text-2xl sm:text-3xl opacity-80"></i>
            </div>
        </div>

        <div class="rounded-2xl p-4 bg-gradient-to-r from-pink-500 to-pink-600 text-white shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs sm:text-sm text-pink-100">Organizations</p>
                    <h2 class="text-xl sm:text-2xl font-bold">{{ number_format($totalOrganizations) }}</h2>
                </div>
                <i class="ri-building-4-line text-2xl sm:text-3xl opacity-80"></i>
            </div>
        </div>

        <div class="rounded-2xl p-4 bg-gradient-to-r from-green-500 to-green-600 text-white shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs sm:text-sm text-green-100">Events</p>
                    <h2 class="text-xl sm:text-2xl font-bold">{{ number_format($totalEvents) }}</h2>
                </div>
                <i class="ri-calendar-event-line text-2xl sm:text-3xl opacity-80"></i>
            </div>
        </div>

        <div class="rounded-2xl p-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs sm:text-sm text-orange-100">Orders</p>
                    <h2 class="text-xl sm:text-2xl font-bold">{{ number_format($totalOrders) }}</h2>
                </div>
                <i class="ri-shopping-cart-2-line text-2xl sm:text-3xl opacity-80"></i>
            </div>
        </div>

        <div class="rounded-2xl p-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs sm:text-sm text-blue-100">Revenue</p>
                    <h2 class="text-xl sm:text-2xl font-bold">{{ $totalRevenue }}</h2>
                </div>
                <i class="ri-bar-chart-2-line text-2xl sm:text-3xl opacity-80"></i>
            </div>
        </div>
    </div>
</section>

<!-- Charts -->
<section class="px-4 sm:px-6 lg:px-8 py-4 grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6">
    <div class="rounded-2xl p-4 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-base sm:text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-3">User Growth</h3>
        <div class="h-72">
            <canvas id="userGrowthChart"></canvas>
        </div>
    </div>
    <div class="rounded-2xl p-4 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-base sm:text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-3">Published Events</h3>
        <div class="h-72">
            <canvas id="publishedEventsChart"></canvas>
        </div>
    </div>
    <div class="rounded-2xl p-4 bg-white dark:bg-gray-800 shadow-md xl:col-span-2">
        <h3 class="text-base sm:text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-3">Most Income</h3>
        <div class="h-80">
            <canvas id="mostIncomeChart"></canvas>
        </div>
    </div>
</section>

<!-- Extra Charts -->
<section class="px-4 sm:px-6 lg:px-8 py-4 grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6">
    <div class="rounded-2xl p-4 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-base sm:text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-3">Report Events</h3>
        <div class="h-80">
            <canvas id="reportEventsChart"></canvas>
        </div>
    </div>

    <div class="rounded-2xl p-4 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-base sm:text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-3">Best Seller</h3>
        <div class="h-80">
            <canvas id="bestSellerChart"></canvas>
        </div>
    </div>
</section>

<!-- Activity & Logs -->
<section class="px-4 sm:px-6 lg:px-8 py-4 grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6">
    <div class="rounded-2xl p-4 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-base sm:text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-3">Recent Activity</h3>
        <ul class="space-y-3 sm:space-y-4 max-h-72 overflow-y-auto">
            @foreach ($recentActivities as $act)
                <li class="flex gap-3">
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center {{ $act['bg_color'] }} rounded-full">
                        <i class="{{ $act['icon'] }} {{ $act['text_color'] }} text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800 dark:text-gray-100 text-sm sm:text-base">
                            {{ $act['message'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $act['created_at'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="rounded-2xl p-4 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-base sm:text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-3">Upcoming Events</h3>
        <div class="max-h-64 overflow-y-auto divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($upcomingEvents as $event)
                <div class="py-2">
                    <p class="font-medium text-gray-700 dark:text-gray-200 text-sm sm:text-base">{{ $event->title }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $event->start_date->format('d M Y H:i') }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">No upcoming events.</p>
            @endforelse
        </div>
    </div>
</section>

<script>
    window.dashboardData = {
        userGrowth: @json($userGrowth),
        bestSellerEvents: @json($bestSellerEvents),
        publishedEvents: @json($publishedEvents),
        reportEvents: @json($reportEvents),
        mostIncome: @json($mostIncome),
    };
</script>
