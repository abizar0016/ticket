<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
            <div class="flex flex-col gap-2">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                    Revenue Reports
                </h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                    Manage all revenue reports
                </p>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Total Revenue</h2>
            <p class="text-2xl sm:text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">
                Rp{{ number_format($totalRevenue, 0, ',', '.') }}
            </p>
        </div>

        <!-- Revenue per Event -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Revenue by Event</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-100">Event</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-100">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @foreach ($revenueByEvent as $event)
                            <tr>
                                <td class="px-4 py-3">{{ $event->title }}</td>
                                <td class="px-4 py-3 font-semibold">
                                    Rp{{ number_format($event->revenue, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Revenue per Month (Chart) -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Revenue by Month</h2>
            <div class="w-full h-64">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Order Detail -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Paid Orders</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Event</th>
                            <th class="px-4 py-3 text-left">Customer</th>
                            <th class="px-4 py-3 text-left">Total</th>
                            <th class="px-4 py-3 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $order->event?->title }}</td>
                                <td class="px-4 py-3">{{ $order->user->name }}</td>
                                <td class="px-4 py-3">Rp{{ number_format($order->uniqueAmount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $orders->links() }}</div>
        </div>
    </div>
</div>
<script>
    window.revenueReportsData = {
        revenueByEvent: @json($revenueByEvent),
    }
</script>
