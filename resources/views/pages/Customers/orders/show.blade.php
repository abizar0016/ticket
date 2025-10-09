@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        <div class="bg-gray-900 dark:bg-gray-900 rounded-xl shadow-sm border border-gray-700 overflow-hidden">
            <!-- Order Header -->
            <div class="bg-indigo-800 px-6 py-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Pesanan {{ $order->name }}</h1>
                        <p class="text-indigo-200 mt-1">
                            {{ $order->created_at->translatedFormat('l, d F Y H:i') }}
                        </p>
                    </div>
                    <div class="mt-3 md:mt-0">
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium 
                        {{ $order->status == 'paid' ? 'bg-green-700 text-green-100' : 'bg-yellow-700 text-yellow-100' }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Payment Instructions -->
                @if ($order->status == 'pending')
                    <div class="bg-blue-900 border-l-4 border-blue-700 rounded-lg mb-8 overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-800 p-3 rounded-full">
                                    <i class="ri-bank-card-line text-blue-400 text-xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold text-blue-200 mb-2">Instruksi Pembayaran</h3>
                                    <div class="space-y-3 text-blue-300">
                                        <p class="text-sm leading-relaxed">
                                            Silakan transfer sesuai jumlah pesanan (<span
                                                class="font-medium">{{ $order->items->sum('quantity') }} item</span>) ke
                                            rekening resmi kami.
                                        </p>

                                        <div class="bg-gray-800 p-4 rounded-lg border border-blue-700">
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-blue-200">
                                                <div>
                                                    <p class="text-xs mb-1">Nama Pemilik</p>
                                                    <p class="font-medium">{{ $event->bank_account_name }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs mb-1">Bank</p>
                                                    <p class="font-medium">{{ $event->bank_name }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs mb-1">Nomor Rekening</p>
                                                    <p class="font-mono font-medium">{{ $event->bank_account_number }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pt-2">
                                            <p class="text-sm mb-1">Total Pembayaran:</p>
                                            <p class="text-3xl font-bold text-blue-100">Rp
                                                {{ number_format($order->uniqueAmount, 0, ',', '.') }}</p>
                                        </div>

                                        <div class="bg-blue-800 p-3 rounded-lg mt-3">
                                            <p class="text-sm flex items-center">
                                                <i class="ri-information-line mr-2 text-blue-400"></i>
                                                Setelah transfer, harap upload bukti pembayaran melalui form dibawah.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Order Summary -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-200 border-b border-gray-700 pb-2 mb-4">Detail Pesanan</h2>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            @if ($item->quantity == 0)
                                @continue
                            @endif

                            <div class="border border-gray-700 rounded-lg p-4 bg-gray-800">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-start space-x-4">
                                        @if ($item->product && $item->product->type !== 'ticket' && $item->product->image)
                                            <div class="flex-shrink-0 h-16 w-16 bg-gray-700 rounded-md overflow-hidden">
                                                <img src="{{ asset($item->product->image) }}"
                                                    class="w-16 h-16 object-cover rounded" />
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-medium text-gray-100">{{ $item->product->title }}</h3>
                                            <p class="text-sm text-gray-300 mt-1">
                                                {{ $item->quantity }} × Rp
                                                {{ number_format($item->product->price, 0, ',', '.') }}
                                            </p>
                                            @if ($item->product->type == 'ticket')
                                                <p class="text-xs text-blue-400 mt-1 flex items-center">
                                                    <i class="ri-ticket-2-line mr-1"></i> Tiket Event
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-100">Rp
                                            {{ number_format($item->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <!-- Attendees for tickets -->
                                @if ($item->product->type == 'ticket' && $item->product->attendees->count() > 0)
                                    <div class="mt-4 pt-4 border-t border-gray-700">
                                        <h4 class="text-sm font-medium text-gray-200 mb-3">Detail Peserta</h4>
                                        <div class="space-y-3">
                                            @foreach ($order->attendees->where('product_id', $item->product_id) as $attendee)
                                                <div class="bg-gray-700 rounded-lg p-3 border border-gray-600">
                                                    <div
                                                        class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 sm:gap-6">
                                                        <div>
                                                            <p class="text-xs text-gray-400">#{{ $loop->iteration }}</p>
                                                            <p class="font-medium text-gray-100">{{ $attendee->name }}</p>
                                                            <p class="text-sm text-gray-300">{{ $attendee->email }}</p>
                                                            <a href="https://wa.me/{{ $attendee->phone }}" target="_blank"
                                                                class="text-sm text-gray-300 hover:underline">{{ $attendee->phone ?? '-' }}
                                                            </a>
                                                            <div class="mt-2 flex items-center">
                                                                <span
                                                                    class="bg-blue-800 text-blue-200 text-xs px-2 py-1 rounded mr-2">
                                                                    {{ $attendee->ticket_code }}
                                                                </span>
                                                                <span
                                                                    class="text-xs px-2 py-1 rounded
                                    {{ $attendee->status == 'active'
                                        ? 'bg-green-700 text-green-100'
                                        : ($attendee->status == 'used'
                                            ? 'bg-purple-700 text-purple-100'
                                            : 'bg-yellow-700 text-yellow-100') }}">
                                                                    {{ strtoupper($attendee->status) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        @if ($attendee->status == 'active' || $attendee->status == 'used')
                                                            <div class="sm:mt-0 flex flex-col items-center sm:items-end">
                                                                <img src="{{ $attendee->url_qrcode }}" alt="QR Code"
                                                                    class="h-32 w-32">
                                                                <p class="text-xs text-right text-gray-400 mt-1">Scan QR
                                                                    Code untuk checkin</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                            <div
                                class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Ringkasan Pesanan</h3>
                            </div>

                            <div class="p-6">

                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Subtotal</span>
                                    <span class="font-semibold text-gray-800 dark:text-gray-100">
                                        Rp {{ number_format($order->subtotal ?? $order->total_price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Kode Unik</span>
                                    <span class="font-semibold text-green-600 dark:text-green-400">
                                        + Rp {{ number_format($order->unique_price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div
                                    class="flex justify-between items-center text-lg font-bold mt-4 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <span class="text-gray-800 dark:text-gray-100">Total Pembayaran</span>
                                    <span class="text-indigo-600 dark:text-indigo-400">
                                        Rp {{ number_format($order->uniqueAmount, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div
                                    class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                                    <div class="flex items-start">
                                        <i class="ri-information-line text-yellow-500 text-lg mt-0.5 mr-2"></i>
                                        <div>
                                            <p class="text-sm text-yellow-700 dark:text-yellow-300 font-medium">
                                                Transfer tepat sebesar:
                                                <span class="font-bold">
                                                    Rp {{ number_format($order->uniqueAmount, 0, ',', '.') }}
                                                </span>
                                            </p>
                                            <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                                                Kode unik <span class="font-bold">{{ $order->unique_price }}</span>
                                                digunakan untuk memudahkan kami mengkonfirmasi pembayaran.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Customer Info -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-200 border-b border-gray-700 pb-2 mb-4">Informasi Pembeli
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 mb-5 text-gray-300">
                        <!-- KIRI -->
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-400">Nama</p>
                                <p class="text-base font-semibold text-white">{{ $order->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Email</p>
                                <p class="text-base font-semibold text-white">{{ $order->email }}</p>
                            </div>
                        </div>

                        <!-- KANAN -->
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-400">Nomor Telepon</p>
                                <a href="https://wa.me/{{ $order->phone }}" target="_blank"
                                    class="text-base font-semibold text-white hover:text-purple-400 transition">
                                    {{ $order->phone ?? '-' }}
                                </a>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Tipe Identitas</p>
                                <p class="text-base font-semibold text-white">{{ $order->identity_type ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Nomor Identitas</p>
                                <p class="text-base font-semibold text-white">{{ $order->identity_number ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    @if ($order->status == 'pending')
                        <!-- Payment Proof Upload -->
                        <div class="p-6 bg-gray-800 border border-gray-700 rounded-xl shadow-sm">
                            <h2 class="text-lg font-semibold text-gray-200 mb-4">Upload Bukti Pembayaran</h2>

                            <form data-success="Thank you for making the payment, we are currently verifying your payment"
                                action="{{ route('payment.proof', $order->id) }}" method="POST"
                                enctype="multipart/form-data" class="ajax-form">
                                @csrf
                                <div class="space-y-4">
                                    <div id="preview-container"
                                        class="{{ $order->payment_proof ? 'text-center' : 'hidden text-center' }}">
                                        <img id="preview-image"
                                            src="{{ $order->payment_proof ? asset($order->payment_proof) : '#' }}"
                                            alt="Preview"
                                            class="mx-auto max-h-[90vh] rounded-md border border-gray-600 shadow-sm">

                                        <button type="button" id="remove-image"
                                            class="mt-2 inline-flex items-center text-sm text-red-500 hover:underline">
                                            <i class="ri-close-line mr-1"></i> Hapus Gambar
                                        </button>
                                    </div>

                                    <div>
                                        <input type="file" name="payment_proof" id="payment_proof" class="hidden"
                                            accept="image/*,.pdf">

                                        <label for="payment_proof"
                                            class="flex items-center justify-between px-4 py-3 bg-gray-700 border border-dashed border-gray-600 rounded-md cursor-pointer hover:bg-gray-600 transition">

                                            <span id="file-name"
                                                class="text-sm text-gray-400 italic truncate max-w-[200px]">
                                                <i
                                                    class="ri-upload-line mr-2 text-gray-400"></i>{{ $order->payment_proof ? basename($order->payment_proof) : 'Pilih File Bukti Pembayaran' }}
                                            </span>

                                        </label>
                                    </div>

                                    <div class="flex justify-center md:justify-end">
                                        <button type="submit"
                                            class="inline-flex items-center px-5 py-2 w-full md:w-1/3 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-700 transition">
                                            <i class="ri-check-line mr-2 text-lg"></i> Konfirmasi Pembayaran
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div
                    class="px-6 py-4 bg-gray-900 border-t border-gray-700 flex flex-col sm:flex-row justify-between space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700 text-center">
                        <i class="ri-arrow-left-line mr-2"></i> Kembali ke Beranda
                    </a>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('orders.customers') }}"
                            class="px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-indigo-700 inline-flex items-center justify-center">
                            <i class="ri-list-check mr-2"></i> Pesanan Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
