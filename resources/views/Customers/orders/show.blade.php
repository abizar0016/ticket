<!DOCTYPE html>
<html lang="en">
@include('components.head.head')

<body>
    @include('components.navbar.navbar')
    @include('components.preloader.preloader')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Order Header -->
            <div class="bg-indigo-600 px-6 py-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Pesanan {{ $order->name }}</h1>
                        <p class="text-indigo-100 mt-1">
                            {{ $order->created_at->translatedFormat('l, d F Y H:i') }}
                        </p>
                    </div>
                    <div class="mt-3 md:mt-0">
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium 
                        {{ $order->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Payment Instructions -->
                @if ($order->status == 'pending')
                    <div class="bg-blue-50 border-l-4 border-blue-400 rounded-lg mb-8 overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full">
                                    <i class="ri-bank-card-line text-blue-600 text-xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Instruksi Pembayaran</h3>

                                    <div class="space-y-3 text-blue-700">
                                        <p class="text-sm leading-relaxed">
                                            Silakan transfer sesuai jumlah pesanan (<span
                                                class="font-medium">{{ $order->items->sum('quantity') }} item</span>) ke
                                            rekening resmi kami.
                                        </p>

                                        <div class="bg-white p-4 rounded-lg border border-blue-100">
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <p class="text-xs text-blue-500 mb-1">Nama Pemilik</p>
                                                    <p class="font-medium">{{ $event->bank_account_name }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-blue-500 mb-1">Bank</p>
                                                    <p class="font-medium">{{ $event->bank_name }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-blue-500 mb-1">Nomor Rekening</p>
                                                    <p class="font-mono font-medium">{{ $event->bank_account_number }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pt-2">
                                            <p class="text-sm text-blue-500 mb-1">Total Pembayaran:</p>
                                            <p class="text-3xl font-bold text-blue-800">Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                        </div>

                                        <div class="bg-blue-100 p-3 rounded-lg mt-3">
                                            <p class="text-sm flex items-center">
                                                <i class="ri-information-line mr-2 text-blue-600"></i>
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
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Detail Pesanan</h2>

                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            @if ($item->quantity == 0)
                                @continue
                            @endif

                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md overflow-hidden">
                                            @if ($item->product && $item->product->image)
                                                <img src="{{ asset($item->product->image) }}"
                                                    class="w-16 h-16 object-cover rounded" />
                                            @else
                                                <div
                                                    class="h-full w-full flex items-center justify-center text-gray-400">
                                                    <i class="ri-image-line text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $item->product->title }}</h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $item->quantity }} × Rp
                                                {{ number_format($item->product->price, 0, ',', '.') }}
                                            </p>
                                            @if ($item->product->type == 'ticket')
                                                <p class="text-xs text-blue-600 mt-1 flex items-center">
                                                    <i class="ri-ticket-2-line mr-1"></i> Tiket Event
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold">Rp
                                            {{ number_format($item->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <!-- Attendees for tickets -->
                                @if ($item->product->type == 'ticket' && $item->product->attendees->count() > 0)
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Detail Peserta</h4>
                                        <div class="space-y-3">
                                            @foreach ($order->attendees->where('product_id', $item->product_id) as $attendee)
                                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                                    <div class="flex justify-between items-center">
                                                        <div>
                                                            <p class="text-xs text-gray-500">#{{ $loop->iteration }}</p>
                                                            <p class="font-medium">{{ $attendee->name }}</p>
                                                            <p class="text-sm text-gray-500">{{ $attendee->email }}</p>
                                                            <div class="mt-2 flex items-center">
                                                                <span
                                                                    class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-2">
                                                                    {{ $attendee->ticket_code }}
                                                                </span>
                                                                <span
                                                                    class="text-xs px-2 py-1 rounded 
                                    {{ $attendee->status == 'active'
                                        ? 'bg-green-100 text-green-800'
                                        : ($attendee->status == 'used'
                                            ? 'bg-purple-100 text-purple-800'
                                            : 'bg-yellow-100 text-yellow-800') }}">
                                                                    {{ strtoupper($attendee->status) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3 flex flex-col items-end">
                                                            <img src="{{ $attendee->url_qrcode }}" alt="QR Code"
                                                                class="h-32 w-32">
                                                            <p class="text-xs text-right text-gray-500 mt-1">Scan QR Code untuk
                                                                checkin</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Subtotal</span>
                            <span class="text-sm text-gray-900">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-sm font-medium text-gray-500">Total</span>
                            <span class="text-lg font-bold text-indigo-600">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Informasi Pembeli</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-medium">{{ $order->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ $order->email }}</p>
                        </div>
                    </div>
                </div>

                @if ($order->status == 'pending')
                    <!-- Payment Proof Upload -->
                    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload Bukti Pembayaran</h2>

                        <form id="payment-proof" action="{{ route('payment.proof', $order->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="space-y-4">
                                <!-- Preview Container -->
                                <div id="preview-container"
                                    class="{{ $order->payment_proof ? 'text-center' : 'hidden text-center' }}">
                                    <img id="preview-image"
                                        src="{{ $order->payment_proof ? asset($order->payment_proof) : '#' }}"
                                        alt="Preview"
                                        class="mx-auto max-h-[90vh] rounded-md border border-gray-200 shadow-sm">

                                    <button type="button" id="remove-image"
                                        class="mt-2 inline-flex items-center text-sm text-red-600 hover:underline">
                                        <i class="ri-close-line mr-1"></i> Hapus Gambar
                                    </button>
                                </div>

                                <!-- Upload Field -->
                                <div>
                                    <input type="file" name="payment_proof" id="payment_proof" class="hidden"
                                        accept="image/*,.pdf">

                                    <label for="payment_proof"
                                        class="flex items-center justify-between px-4 py-3 bg-gray-50 border border-dashed border-gray-300 rounded-md cursor-pointer hover:bg-gray-100 transition">
                                        <span class="text-sm text-gray-600">
                                            <i class="ri-upload-line mr-2 text-gray-500"></i> Pilih File Bukti
                                            Pembayaran
                                        </span>
                                        <span id="file-name"
                                            class="text-sm text-gray-400 italic truncate max-w-[200px]">{{ $order->payment_proof ? basename($order->payment_proof) : '' }}</span>
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-right">
                                    <button type="submit"
                                        class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-700 transition">
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
                class="px-6 py-4 bg-gray-50 border-t flex flex-col sm:flex-row justify-between space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 text-center">
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
</body>

</html>
