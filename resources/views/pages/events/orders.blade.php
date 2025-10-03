<div class="min-h-screen bg-gray-50 p-3 sm:p-4 md:p-6">
    <!-- Dynamic Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 md:gap-8">
        <!-- Animated Header -->
        <div
            class="lg:col-span-12 relative overflow-hidden rounded-xl sm:rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 p-4 sm:p-6 md:p-8 mb-4 sm:mb-6 md:mb-8 shadow-lg sm:shadow-xl md:shadow-2xl transition-all duration-500 hover:shadow-xl sm:hover:shadow-2xl group">
            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 md:gap-6">
                <div
                    class="p-2 sm:p-3 md:p-4 rounded-lg sm:rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-md">
                    <i class="ri-shopping-cart-line text-xl sm:text-2xl md:text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">Event Orders</h1>
                    <p class="text-indigo-600/80 text-sm sm:text-base md:text-lg mt-1 sm:mt-2">Manage all event orders
                        and payments</p>
                </div>
            </div>
            <div
                class="absolute right-4 sm:right-6 md:right-10 top-0 text-black/10 text-5xl sm:text-7xl md:text-9xl z-0">
                <i class="ri-shopping-cart-line"></i>
            </div>
        </div>

        <!-- Main Content (8/12 width) -->
        <div class="lg:col-span-8">
            <!-- Search and Filter Bar -->
            <div
                class="bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-6 mb-4 sm:mb-6 shadow-lg sm:shadow-xl border border-gray-100">
                <form action="" method="GET"
                    class="flex flex-col md:flex-row gap-3 sm:gap-4 items-stretch md:items-center">
                    <div class="relative w-full md:w-80 lg:w-96 group">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors">
                            <i class="ri-search-line text-sm sm:text-base"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search orders..."
                            class="bg-white border-2 border-gray-200 text-gray-900 text-xs sm:text-sm rounded-lg sm:rounded-xl focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none block w-full pl-9 sm:pl-10 p-2 sm:p-2.5 transition-all duration-300 group-hover:shadow-sm sm:group-hover:shadow-md">
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit"
                            class="px-3 sm:px-4 py-2 w-full md:w-auto border-2 border-transparent rounded-lg sm:rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-xs sm:text-sm font-medium text-white hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 flex items-center justify-center gap-1 sm:gap-2">
                            <i class="ri-search-line text-sm sm:text-base"></i> Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Orders Table -->
            <div
                class="bg-white rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px]">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Order
                                </th>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Date & Time
                                </th>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-right text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td
                                        class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-gray-900 font-medium text-xs sm:text-sm">
                                        #{{ $loop->iteration }}
                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 sm:h-9 sm:w-9 md:h-10 md:w-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 flex items-center justify-center text-white font-medium sm:font-bold text-xs sm:text-sm">
                                                {{ substr($order->name, 0, 1) }}{{ substr(strstr($order->name, ' '), 1, 1) ?? '' }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900 text-xs sm:text-sm md:text-base">
                                                    {{ $order->name }}</div>
                                                <div class="text-gray-500 text-2xs sm:text-xs">{{ $order->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap">
                                        <div class="text-gray-900 text-xs sm:text-sm">
                                            {{ $order->created_at->format('M d, Y') }}</div>
                                        <div class="text-gray-500 text-2xs sm:text-xs">
                                            {{ $order->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap">
                                        @if ($order->status === 'paid')
                                            <span
                                                class="px-2 py-1 text-2xs sm:text-xs rounded-full bg-green-100 text-green-800 font-medium flex items-center gap-1 w-fit">
                                                <i class="ri-checkbox-circle-line text-xs sm:text-sm"></i> Paid
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-2xs sm:text-xs rounded-full bg-yellow-100 text-yellow-800 font-medium flex items-center gap-1 w-fit">
                                                <i class="ri-time-line text-xs sm:text-sm"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-gray-900 font-medium text-xs sm:text-sm">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-right">
                                        <div class="flex justify-end items-center gap-1 sm:gap-2">
                                            <a href="{{ route(Auth::user()->role === 'superadmin' ? 'superAdmin.events.orders.show' :  'admin.events.orders.show', [$events->id, $order->id]) }}"
                                                class="p-1 sm:p-1.5 md:p-2 text-gray-600 hover:text-indigo-600 transition"
                                                title="View Details">
                                                <i class="ri-eye-line text-base sm:text-lg md:text-xl"></i>
                                            </a>
                                            <form id="delete-order-{{ $order->id }}"
                                                class="ajax-form"
                                                data-success="Deleted successfully."
                                                data-confirm="Are you sure you want to delete this order?"
                                                action="{{ route('orders.destroy', $order->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1 sm:p-1.5 md:p-2 text-gray-600 hover:text-red-600 transition cursor-pointer"
                                                    title="Delete">
                                                    <i class="ri-delete-bin-line text-base sm:text-lg md:text-xl"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 sm:px-6 py-6 text-center">
                                        <div
                                            class="flex flex-col items-center justify-center gap-2 sm:gap-3 text-gray-400">
                                            <i class="ri-shopping-cart-line text-2xl sm:text-3xl md:text-4xl"></i>
                                            <p class="text-sm sm:text-base md:text-lg">No orders found</p>
                                            <p class="text-2xs sm:text-xs md:text-sm">Try adjusting your search or
                                                filters</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 border-t border-gray-200">
                    {{ $orders->appends(['content' => 'orders'])->links('pagination::default') }}
                </div>
            </div>
        </div>

        <!-- Right Sidebar (4/12 width) -->
        <div class="lg:col-span-4">
            <div class="sticky top-4 sm:top-6 space-y-4 sm:space-y-6">
                <!-- Summary Card -->
                <div
                    class="bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-6 shadow-lg sm:shadow-xl border border-indigo-100 transition-all duration-500 hover:shadow-md sm:hover:shadow-lg hover:-translate-y-0.5 sm:hover:-translate-y-1">
                    <h3
                        class="text-base sm:text-lg md:text-xl font-bold text-gray-800 mb-2 sm:mb-3 md:mb-4 flex items-center gap-1 sm:gap-2">
                        <i class="ri-line-chart-line text-indigo-500 text-lg sm:text-xl md:text-2xl"></i>
                        Orders Summary
                    </h3>

                    <div class="space-y-3 sm:space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-2xs sm:text-xs md:text-sm font-medium text-gray-700">Total
                                    Orders</span>
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-bold text-gray-900">{{ $orders->total() }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-2xs sm:text-xs md:text-sm font-medium text-gray-700">Paid</span>
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-bold text-gray-900">{{ $paidOrdersCount }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 sm:h-2">
                                <div class="bg-green-500 h-1.5 sm:h-2 rounded-full"
                                    style="width: {{ $paidPercentage }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-2xs sm:text-xs md:text-sm font-medium text-gray-700">Pending</span>
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-bold text-gray-900">{{ $pendingOrdersCount }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 sm:h-2">
                                <div class="bg-yellow-500 h-1.5 sm:h-2 rounded-full"
                                    style="width: {{ $pendingPercentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Card -->
                <div
                    class="bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-6 shadow-lg sm:shadow-xl border border-blue-100 transition-all duration-500 hover:shadow-md sm:hover:shadow-lg hover:-translate-y-0.5 sm:hover:-translate-y-1">
                    <h3
                        class="text-base sm:text-lg md:text-xl font-bold text-gray-800 mb-2 sm:mb-3 md:mb-4 flex items-center gap-1 sm:gap-2">
                        <i class="ri-money-dollar-circle-line text-blue-500 text-lg sm:text-xl md:text-2xl"></i>
                        Total Revenue
                    </h3>

                    <div class="flex items-end gap-2">
                        <span class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">Rp
                            {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-2xs sm:text-xs md:text-sm text-gray-500 mt-1 sm:mt-2">from {{ $orders->total() }}
                        orders</p>
                </div>
            </div>
        </div>
    </div>
</div>