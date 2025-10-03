<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900">
                Orders
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                Manage all orders
            </p>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">No. </th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Customer</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Event</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Items</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Total</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Date</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($orders as $order)
                        <tr class="hover:shadow-md hover:-translate-y-0.5 transition transform bg-white">
                            <td class="px-6 py-5 font-semibold text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($order->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $order->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-gray-700">
                                {{ $order->event->title ?? '-' }}
                            </td>
                            <td class="px-6 py-5">
                                <ul class="space-y-1 text-xs text-gray-600">
                                    @foreach ($order->items as $item)
                                        <li>• <span class="capitalize">{{ $item->product->type }}</span> -
                                            {{ $item->product->title }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-5 font-bold text-indigo-600">
                                Rp{{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5">
                                @if ($order->status === 'paid')
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        <i class="ri-check-line mr-1"></i> Paid
                                    </span>
                                @elseif($order->status === 'pending')
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                        <i class="ri-time-line mr-1"></i> Pending
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">
                                        <i class="ri-close-line mr-1"></i> Canceled
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-sm text-gray-500">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="#"
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 shadow transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
    </div>
</div>
