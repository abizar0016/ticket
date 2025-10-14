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

    <!-- Orders Cards -->
    <div class="space-y-4">
        @foreach ($orders as $order)
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-4 sm:p-6 hover:shadow-xl transition transform hover:-translate-y-0.5">
            
            <!-- Top Row: No, Customer, Event, Status -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                <div class="flex items-center gap-3">
                    <!-- Nomor urut -->
                    <span class="text-gray-400 dark:text-gray-300 font-semibold">#{{ $loop->iteration }}</span>

                    <!-- Customer Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 text-white flex items-center justify-center font-bold">
                            {{ strtoupper(substr($order->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-100">{{ $order->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Event & Status -->
                <div class="flex items-center gap-3 mt-2 sm:mt-0">
                    <p class="text-sm text-gray-700 dark:text-gray-100 font-medium">{{ $order->event->title ?? '-' }}</p>

                    @if ($order->status === 'paid')
                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200">
                            <i class="ri-check-line mr-1"></i> Paid
                        </span>
                    @elseif($order->status === 'pending')
                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200">
                            <i class="ri-time-line mr-1"></i> Pending
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200">
                            <i class="ri-close-line mr-1"></i> Canceled
                        </span>
                    @endif
                </div>
            </div>

            <!-- Items List -->
            <div class="mt-3 text-sm text-gray-700 dark:text-gray-100">
                <ul class="list-disc list-inside">
                    @foreach ($order->items as $item)
                        <li><span class="capitalize">{{ $item->product->type }}</span> - {{ $item->product->title }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Bottom Row: Total, Date, Action -->
            <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                <p class="font-bold text-indigo-600 dark:text-indigo-400">Rp{{ number_format($order->uniqueAmount,0,',','.') }}</p>
                <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $order->created_at->format('d M Y, H:i') }}</p>
                <a href="{{ route(Auth::user()->role === 'superadmin' ? 'superAdmin.events.orders.show' :  'admin.events.orders.show', [$order->event->id, $order->id]) }}" class="px-2 py-1 text-xs rounded-md bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 flex items-center space-x-1">
                    <i class="ri-eye-line"></i><span>View</span>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
