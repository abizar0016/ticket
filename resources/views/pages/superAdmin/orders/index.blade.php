<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                Orders
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                Manage all orders
            </p>
        </div>
    </div>

    <!-- Orders Table -->
    <div
        class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-700 text=gray-600 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold">No. </th>
                        <th class="px-6 py-4 text-sm font-semibold">Customer</th>
                        <th class="px-6 py-4 text-sm font-semibold">Event</th>
                        <th class="px-6 py-4 text-sm font-semibold">Items</th>
                        <th class="px-6 py-4 text-sm font-semibold">Total</th>
                        <th class="px-6 py-4 text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-sm font-semibold">Date</th>
                        <th class="px-6 py-4 text-sm font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($orders as $order)
                        <tr
                            class="hover:shadow-md dark:hover:shadow-gray-700 hover:-translate-y-0.5 transition transform bg-white dark:bg-gray-800">
                            <td class="px-6 py-5 font-semibold text-gray-800 dark:text-gray-100">{{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 text-white flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($order->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-100">{{ $order->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-gray-700 dark:text-gray-100">
                                {{ $order->event->title ?? '-' }}
                            </td>
                            <td class="px-6 py-5">
                                <ul class="space-y-1 text-xs text-gray-700 dark:text-gray-100">
                                    @foreach ($order->items as $item)
                                        <li>• <span class="capitalize">{{ $item->product->type }}</span> -
                                            {{ $item->product->title }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-5 font-bold text-indigo-600 dark:text-indigo-400">
                                Rp{{ number_format($order->uniqueAmount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5">
                                @if ($order->status === 'paid')
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200">
                                        <i class="ri-check-line mr-1"></i> Paid
                                    </span>
                                @elseif($order->status === 'pending')
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200">
                                        <i class="ri-time-line mr-1"></i> Pending
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200">
                                        <i class="ri-close-line mr-1"></i> Canceled
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-100">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route(Auth::user()->role === 'superadmin' ? 'superAdmin.events.orders.show' :  'admin.events.orders.show', [$order->event->id, $order->id]) }}"
                                    class="px-2 py-1 text-xs rounded-md bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 flex items-center space-x-1">
                                    <i class="ri-eye-line"></i><span>View</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
