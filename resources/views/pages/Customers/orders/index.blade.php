@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Pesanan Saya</h1>

        @if ($orders->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($orders as $order)
                        <a href="{{ route('orders.show', $order->id) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                            <li class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <span
                                                class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                                <i class="ri-shopping-bag-line text-indigo-600 dark:text-indigo-400"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Order
                                                {{ $loop->iteration }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $order->created_at->translatedFormat('d M Y') }}
                                                • {{ $order->items->sum('quantity') }} item </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium
        @if ($order->status === 'paid') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
        @elseif ($order->status === 'expired')
            bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
        @else
            bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 @endif">
                                            {{ strtoupper($order->status) }}
                                        </span>

                                        <span class="text-sm font-bold">
                                            Rp {{ number_format($order->uniqueAmount, 0, ',', '.') }}
                                        </span>

                                        <i class="ri-arrow-right-s-line"></i>
                                    </div>
                                </div>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden text-center py-12">
                <i class="ri-shopping-bag-line text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Belum ada pesanan</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pesanan yang Anda buat akan muncul di sini.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 dark: border border-transparent rounded-lg text-sm font-medium text-white hover:bg-indigo-700">
                        <i class="ri-calendar-2-line mr-2"></i> Cari Event
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
