<!-- Stat Cards -->
<section>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-6">
        <div class="rounded-2xl p-5 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-indigo-100">Total Users</p>
                    <h2 class="text-2xl font-bold">12,450</h2>
                    <p class="text-xs mt-1 text-indigo-200">+12.5% this month</p>
                </div>
                <i class="ri-user-3-line text-3xl opacity-80"></i>
            </div>
        </div>
        <div class="rounded-2xl p-5 bg-gradient-to-r from-pink-500 to-pink-600 text-white shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-pink-100">Organizations</p>
                    <h2 class="text-2xl font-bold">320</h2>
                    <p class="text-xs mt-1 text-pink-200">+5.2% this month</p>
                </div>
                <i class="ri-building-4-line text-3xl opacity-80"></i>
            </div>
        </div>
        <div class="rounded-2xl p-5 bg-gradient-to-r from-green-500 to-green-600 text-white shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-green-100">Events</p>
                    <h2 class="text-2xl font-bold">1,284</h2>
                    <p class="text-xs mt-1 text-green-200">-3.1% this month</p>
                </div>
                <i class="ri-calendar-event-line text-3xl opacity-80"></i>
            </div>
        </div>
        <div class="rounded-2xl p-5 bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-orange-100">Orders</p>
                    <h2 class="text-2xl font-bold">45,210</h2>
                    <p class="text-xs mt-1 text-orange-200">+24.8% this month</p>
                </div>
                <i class="ri-shopping-cart-2-line text-3xl opacity-80"></i>
            </div>
        </div>
        <div class="rounded-2xl p-5 bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-blue-100">Revenue</p>
                    <h2 class="text-2xl font-bold">$2.3M</h2>
                    <p class="text-xs mt-1 text-blue-200">+18.3% this month</p>
                </div>
                <i class="ri-bar-chart-2-line text-3xl opacity-80"></i>
            </div>
        </div>
    </div>
</section>

<!-- Charts -->
<section class="py-6 grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="rounded-2xl p-5 bg-white dark:bg-gray-800 shadow-md col-span-2">
        <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-4">User Growth</h3>
        <canvas id="userGrowthChart" height="120"></canvas>
    </div>
    <div class="rounded-2xl p-5 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-4">Event Distribution</h3>
        <canvas id="eventDistributionChart" height="120"></canvas>
    </div>
    <div class="rounded-2xl p-5 bg-white dark:bg-gray-800 shadow-md col-span-3">
        <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-4">Revenue Trend</h3>
        <canvas id="revenueTrendChart" height="160"></canvas>
    </div>
</section>

<!-- Extra Charts -->
<section class="py-6 grid grid-cols-1 xl:grid-cols-2 gap-6">
    <div class="rounded-2xl p-5 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-4">Active Users by Platform</h3>
        <canvas id="platformChart" height="200"></canvas>
    </div>
    <div class="rounded-2xl p-5 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-4">System Performance</h3>
        <canvas id="performanceChart" height="200"></canvas>
    </div>
</section>

<!-- Activity & Logs -->
<section class="py-6 grid grid-cols-1 xl:grid-cols-2 gap-6">
    <div class="rounded-2xl p-5 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-4">Recent Activity</h3>
        <ul class="space-y-4">
            <li class="flex gap-3">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-full">
                    <i class="ri-user-add-line text-indigo-500 dark:text-indigo-300 text-xl"></i>
                </div>
                <div>
                    <p class="font-medium">New user registered</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">John Doe joined</p>
                    <p class="text-xs text-gray-500 mt-1">2h ago</p>
                </div>
            </li>
            <li class="flex gap-3">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-full">
                    <i class="ri-calendar-event-fill text-green-500 dark:text-green-300 text-xl"></i>
                </div>
                <div>
                    <p class="font-medium">Event published</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Tech Summit 2025</p>
                    <p class="text-xs text-gray-500 mt-1">1d ago</p>
                </div>
            </li>
        </ul>
    </div>

    <div class="rounded-2xl p-5 bg-white dark:bg-gray-800 shadow-md">
        <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-100 mb-4">System Logs</h3>
        <div class="max-h-64 overflow-y-auto space-y-2 text-sm font-mono">
            <div class="p-2 rounded bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400">
                [INFO] 09:45 - Backup completed
            </div>
            <div class="p-2 rounded bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400">
                [WARN] 08:12 - High memory usage
            </div>
            <div class="p-2 rounded bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400">
                [ERROR] 07:55 - DB timeout
            </div>
        </div>
    </div>
</section>
