@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 flex flex-col lg:flex-row gap-8">
        <!-- Main Checkout Form -->
        <section class="lg:w-2/3 w-full">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-indigo-600 px-6 py-4">
                    <h2 class="text-2xl md:text-3xl font-bold text-white">
                        Checkout
                    </h2>
                </div>

                <div class="p-6">
                    @if (isset($checkoutData['expires_at']))
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <i class="ri-error-warning-fill text-yellow-400 text-2xl"></i>
                                <p class="ml-3 text-sm text-yellow-700">
                                    Sesi ini akan kadaluarsa pada
                                    <span class="font-medium">
                                        {{ \Carbon\Carbon::parse($checkoutData['expires_at'])->translatedFormat('l, d F Y H:i') }}
                                        WIB
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('checkouts.submit') }}" method="POST" class="space-y-6" id="checkout-form">
                        @csrf
                        <input type="hidden" name="token" value="{{ $checkoutData['token'] }}">

                        <!-- Buyer Info Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Pembeli</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="buyer_name" required placeholder="John Doe"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition duration-200">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span
                                            class="text-red-500">*</span></label>
                                    <input type="number" name="phone" id="buyer_phone" required placeholder="08123456789"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition duration-200">
                                    <p class="text-xs text-gray-500 mt-1">
                                        Tiket akan dikirim ke nomor telepon ini setelah dikonfirmasi.
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" id="buyer_email" required placeholder="Jhon@Doe.com"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition duration-200">
                                <p class="text-xs text-gray-500 mt-1">
                                    Tiket akan dikirim ke alamat email ini setelah dikonfirmasi.
                                </p>
                            </div>
                        </div>

                        {{-- Attendees --}}
                        @if (count($tickets) > 0)
                            <div class="space-y-6">
                                @foreach ($tickets as $ticket)
                                    @if ($ticket['quantity'] > 0)
                                        @php
                                            $product = $products[$ticket['product_id']] ?? null;
                                        @endphp

                                        <div class="space-y-4 border border-gray-200 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center justify-between border-b pb-2">
                                                @if (!empty($product->title))
                                                    <h3 class="text-lg font-semibold text-gray-800 truncate max-w-xs block"
                                                        title="{{ $product->title }}">
                                                        Ticket {{ $product->title }} ({{ $ticket['quantity'] }})
                                                    </h3>
                                                @else
                                                    <h3 class="text-lg font-semibold text-gray-800">
                                                        Ticket ({{ $ticket['quantity'] }})
                                                    </h3>
                                                @endif

                                                @if ($ticket['quantity'] > 1)
                                                    <button type="button"
                                                        class="copy-attendee-btn flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium transition duration-200"
                                                        data-product="{{ $ticket['product_id'] }}">
                                                        <i class="ri-file-copy-line mr-2"></i>
                                                        Copy ke Semua
                                                    </button>
                                                @endif
                                            </div>

                                            <div class="space-y-4 attendee-list" data-product="{{ $ticket['product_id'] }}">
                                                @for ($i = 0; $i < $ticket['quantity']; $i++)
                                                    <div
                                                        class="border border-gray-200 rounded-lg p-4 bg-gray-50 attendee-item">
                                                        <h4 class="font-medium mb-3 text-gray-700 flex items-center">
                                                            <i class="ri-user-line text-indigo-500 text-2xl mr-3"></i>
                                                            Attendee {{ $i + 1 }}
                                                        </h4>

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">Nama
                                                                    <span class="text-red-500">*</span></label>
                                                                <input type="text"
                                                                    name="attendees[{{ $ticket['product_id'] }}][{{ $i }}][name]"
                                                                    placeholder="John Doe"
                                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none attendee-name"
                                                                    required>
                                                            </div>

                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">Nomor
                                                                    Telepon <span class="text-red-500">*</span></label>
                                                                <input type="number"
                                                                    name="attendees[{{ $ticket['product_id'] }}][{{ $i }}][phone]"
                                                                    placeholder="08123456789"
                                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none attendee-phone"
                                                                    required>
                                                            </div>

                                                            <div class="md:col-span-2">
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">Email
                                                                    <span class="text-red-500">*</span></label>
                                                                <input type="email"
                                                                    name="attendees[{{ $ticket['product_id'] }}][{{ $i }}][email]"
                                                                    placeholder="Jhon@Doe.com"
                                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none attendee-email"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        {{-- Promo Code Section --}}
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="ri-coupon-2-line text-indigo-500 text-2xl mr-3"></i>
                                Kode Promo
                            </h4>

                            <input type="hidden" id="checkout_token" name="token" value="{{ $checkoutData['token'] }}">
                            <meta name="csrf-token" content="{{ csrf_token() }}">

                            <div id="promo-message-container">
                                <!-- Pesan error/success akan ditampilkan di sini -->
                            </div>

                            <div id="promo-code-container">
                                @php
                                    $hasPromo = !empty($checkoutData['applied_promo']);
                                    $promoData = $checkoutData['applied_promo'] ?? null;
                                @endphp

                                @if (!$hasPromo)
                                    <div class="flex md:flex-row flex-col justify-between w-full gap-2">
                                        <input type="text" id="promo_code_input" name="promo_code"
                                            placeholder="Masukkan kode promo"
                                            class="md:w-3/4 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none">
                                        <button id="promo_btn"
                                            class="md:w-1/4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                            Terapkan
                                        </button>
                                    </div>
                                @else
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <span
                                                class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                                                {{ $promoData['code'] }}
                                            </span>
                                            <span class="ml-2 text-sm text-gray-600" id="applied_discount_text">
                                                @if ($promoData['type'] === 'percentage')
                                                    {{ $promoData['discount'] }}% discount
                                                @else
                                                    Rp {{ number_format($promoData['discount'], 0, ',', '.') }}
                                                    discount
                                                @endif
                                            </span>
                                        </div>
                                        <button type="button" id="remove_promo_btn"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center">
                                            <i class="ri-close-line mr-1"></i> Hapus
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center">
                                <i class="ri-shopping-bag-line mr-2"></i>
                                Buat Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Order Summary Sidebar -->
        <aside class="lg:w-1/3 w-full lg:pl-4 lg:sticky lg:top-20 lg:h-fit">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="text-xl font-bold text-gray-800">Ringkasan Pesanan</h3>
                </div>

                <div class="p-6">
                    <!-- Event Info -->
                    @if ($products->first()->event)
                        <div class="mb-6">
                            <div class="flex items-center gap-4 mb-3">
                                <img src="{{ asset($products->first()->event->event_image) }}" alt="Event Image"
                                    class="w-14 h-14 rounded-lg object-cover border border-gray-200">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $products->first()->event->title }}
                                    </h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="ri-calendar-2-line"></i>
                                        {{ $products->first()->event->start_date->format('d M Y') }} -
                                        {{ $products->first()->event->end_date->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tickets -->
                    @if (count($checkoutData['tickets']) > 0)
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="ri-ticket-2-line text-indigo-500 mr-2"></i>
                                Tiket
                            </h4>
                            <ul class="space-y-3">
                                @foreach ($checkoutData['tickets'] as $ticket)
                                    @if (isset($products[$ticket['product_id']]) && $ticket['quantity'] > 0)
                                        <li class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-gray-800 truncate max-w-[180px] block"
                                                    title="{{ $products[$ticket['product_id']]->title }}">
                                                    {{ $products[$ticket['product_id']]->title }}
                                                </p>

                                                <p class="text-sm text-gray-500 mt-1">Qty: {{ $ticket['quantity'] }}
                                                </p>
                                            </div>
                                            <p class="font-semibold text-gray-800 whitespace-nowrap">Rp
                                                {{ number_format($products[$ticket['product_id']]->price * $ticket['quantity'], 0, ',', '.') }}
                                            </p>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Merchandise -->
                    @if (count($checkoutData['merchandise']) > 0)
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="ri-shopping-bag-3-line text-indigo-500 mr-2"></i>
                                Merchandise
                            </h4>
                            <ul class="space-y-3">
                                @foreach ($checkoutData['merchandise'] as $merch)
                                    @if (isset($products[$merch['product_id']]) && $merch['quantity'] > 0)
                                        <li class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-gray-800 truncate max-w-[180px] block"
                                                    title="{{ $products[$merch['product_id']]->title }}">
                                                    {{ $products[$merch['product_id']]->title }}
                                                </p>
                                                <p class="text-sm text-gray-500 mt-1">Qty: {{ $merch['quantity'] }}
                                                </p>
                                            </div>
                                            <p class="font-semibold text-gray-800 whitespace-nowrap">Rp
                                                {{ number_format($products[$merch['product_id']]->price * $merch['quantity'], 0, ',', '.') }}
                                            </p>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Total -->
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium text-gray-700">Subtotal</span>
                            <span class="font-semibold text-gray-800" id="subtotal_amount">
                                Rp
                                {{ number_format(
                                    array_reduce(
                                        $checkoutData['tickets'],
                                        function ($carry, $item) use ($products) {
                                            return $carry + $products[$item['product_id']]->price * $item['quantity'];
                                        },
                                        0,
                                    ) +
                                        array_reduce(
                                            $checkoutData['merchandise'],
                                            function ($carry, $item) use ($products) {
                                                return $carry + $products[$item['product_id']]->price * $item['quantity'];
                                            },
                                            0,
                                        ),
                                    0,
                                    ',',
                                    '.',
                                ) }}
                            </span>
                        </div>

                        <div id="discount_row"
                            class="{{ !$hasPromo ? 'hidden' : '' }} flex justify-between items-center mb-2">
                            <span class="font-medium text-gray-700">Diskon (<span
                                    id="discount_code">{{ $hasPromo ? $promoData['code'] : '' }}</span>)</span>
                            <span class="font-semibold text-red-500" id="discount_amount">
                                @if ($hasPromo)
                                    - Rp
                                    {{ number_format(
                                        $promoData['type'] === 'percentage'
                                            ? (array_reduce(
                                                    $checkoutData['tickets'],
                                                    function ($carry, $item) use ($products) {
                                                        return $carry + $products[$item['product_id']]->price * $item['quantity'];
                                                    },
                                                    0,
                                                ) +
                                                    array_reduce(
                                                        $checkoutData['merchandise'],
                                                        function ($carry, $item) use ($products) {
                                                            return $carry + $products[$item['product_id']]->price * $item['quantity'];
                                                        },
                                                        0,
                                                    )) *
                                                ($promoData['discount'] / 100)
                                            : $promoData['discount'],
                                        0,
                                        ',',
                                        '.',
                                    ) }}
                                @else
                                    - Rp 0
                                @endif
                            </span>
                        </div>

                        <div
                            class="flex justify-between items-center text-lg font-bold mt-4 pt-2 border-t border-gray-200">
                            <span class="text-gray-800">Total</span>
                            <span class="text-indigo-600" id="total_amount">
                                Rp
                                @if ($hasPromo)
                                    {{ number_format(
                                        array_reduce(
                                            $checkoutData['tickets'],
                                            function ($carry, $item) use ($products) {
                                                return $carry + $products[$item['product_id']]->price * $item['quantity'];
                                            },
                                            0,
                                        ) +
                                            array_reduce(
                                                $checkoutData['merchandise'],
                                                function ($carry, $item) use ($products) {
                                                    return $carry + $products[$item['product_id']]->price * $item['quantity'];
                                                },
                                                0,
                                            ) -
                                            ($promoData['type'] === 'percentage'
                                                ? (array_reduce(
                                                        $checkoutData['tickets'],
                                                        function ($carry, $item) use ($products) {
                                                            return $carry + $products[$item['product_id']]->price * $item['quantity'];
                                                        },
                                                        0,
                                                    ) +
                                                        array_reduce(
                                                            $checkoutData['merchandise'],
                                                            function ($carry, $item) use ($products) {
                                                                return $carry + $products[$item['product_id']]->price * $item['quantity'];
                                                            },
                                                            0,
                                                        )) *
                                                    ($promoData['discount'] / 100)
                                                : $promoData['discount']),
                                        0,
                                        ',',
                                        '.',
                                    ) }}
                                @else
                                    {{ number_format(
                                        array_reduce(
                                            $checkoutData['tickets'],
                                            function ($carry, $item) use ($products) {
                                                return $carry + $products[$item['product_id']]->price * $item['quantity'];
                                            },
                                            0,
                                        ) +
                                            array_reduce(
                                                $checkoutData['merchandise'],
                                                function ($carry, $item) use ($products) {
                                                    return $carry + $products[$item['product_id']]->price * $item['quantity'];
                                                },
                                                0,
                                            ),
                                        0,
                                        ',',
                                        '.',
                                    ) }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    @if ($errors->any())
        <div class="fixed bottom-6 right-6 z-50 animate-[slideIn_0.5s_ease-out_forwards]">
            <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200 shadow-lg max-w-xs">
                <div class="flex items-start gap-3">
                    <i class="ri-close-circle-fill text-red-500 text-xl mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h4 class="font-medium mb-1">Terjadi Kesalahan</h4>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const tokenField = document.querySelector('input[name="token"]');
            const token = tokenField ? tokenField.value : null;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const getStorageKey = () => `checkout_form_data_${token}`;

            // ===============================
            // FORM DATA STORAGE
            // ===============================
            function saveFormData() {
                const formData = {
                    buyer_name: document.getElementById('buyer_name')?.value || '',
                    buyer_email: document.getElementById('buyer_email')?.value || '',
                    buyer_phone: document.getElementById('buyer_phone')?.value || '',
                    attendees: {},
                    token: token,
                    timestamp: Date.now()
                };

                document.querySelectorAll('.attendee-item').forEach(item => {
                    const productId = item.closest('.attendee-list').dataset.product;
                    const index = Array.from(item.parentNode.children).indexOf(item);
                    formData.attendees[productId] = formData.attendees[productId] || [];
                    formData.attendees[productId][index] = {
                        name: item.querySelector('.attendee-name').value,
                        phone: item.querySelector('.attendee-phone').value,
                        email: item.querySelector('.attendee-email').value
                    };
                });

                localStorage.setItem(getStorageKey(), JSON.stringify(formData));
            }

            function restoreFormData() {
                const savedData = localStorage.getItem(getStorageKey());
                if (!savedData) return;
                try {
                    const formData = JSON.parse(savedData);
                    if (formData.token !== token) return;

                    // Restore buyer info
                    ['buyer_name', 'buyer_email', 'buyer_phone'].forEach(id => {
                        const el = document.getElementById(id);
                        if (el && formData[id] !== undefined) el.value = formData[id];
                    });

                    // Restore attendees
                    if (formData.attendees) {
                        for (const [productId, attendees] of Object.entries(formData.attendees)) {
                            attendees.forEach((att, index) => {
                                const item = document.querySelector(
                                    `.attendee-list[data-product="${productId}"] .attendee-item:nth-child(${index + 1})`
                                );
                                if (!item) return;
                                item.querySelector('.attendee-name').value = att.name || '';
                                item.querySelector('.attendee-phone').value = att.phone || '';
                                item.querySelector('.attendee-email').value = att.email || '';
                            });
                        }
                    }
                } catch (e) {
                    console.error('Error restoring form data:', e);
                }
            }

            function clearFormData() {
                localStorage.removeItem(getStorageKey());
            }

            function cleanupOldStorage() {
                const prefix = 'checkout_form_data_';
                for (let i = 0; i < localStorage.length; i++) {
                    const key = localStorage.key(i);
                    if (key && key.startsWith(prefix)) {
                        try {
                            const data = JSON.parse(localStorage.getItem(key));
                            if (data && data.timestamp) {
                                if (data.timestamp < Date.now() - 3600000) localStorage.removeItem(key);
                            }
                        } catch (e) {
                            localStorage.removeItem(key);
                        }
                    }
                }
            }

            // ===============================
            // COPY ATTENDEE TO ALL
            // ===============================
            document.querySelectorAll('.copy-attendee-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const productId = btn.dataset.product;
                    const firstAttendee = document.querySelector(
                        `.attendee-list[data-product="${productId}"] .attendee-item:first-child`
                    );
                    if (!firstAttendee) return;

                    const values = {
                        name: firstAttendee.querySelector('.attendee-name').value,
                        phone: firstAttendee.querySelector('.attendee-phone').value,
                        email: firstAttendee.querySelector('.attendee-email').value,
                    };

                    document.querySelectorAll(
                        `.attendee-list[data-product="${productId}"] .attendee-item`
                    ).forEach(item => {
                        item.querySelector('.attendee-name').value = values.name;
                        item.querySelector('.attendee-phone').value = values.phone;
                        item.querySelector('.attendee-email').value = values.email;
                    });

                    saveFormData();
                });
            });

            // ===============================
            // PROMO HANDLER
            // ===============================
            function getPromoUrl(action) {
                if (action === 'apply') return '{{ route('promos.apply') }}';
                if (action === 'remove') return '{{ route('promos.remove') }}';
                return null;
            }

            async function handlePromo(action, data = {}) {
                const url = getPromoUrl(action);
                if (!url) return Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Promo URL tidak ditemukan.',
                    confirmButtonColor: '#6366f1'
                });

                const btnId = action === 'apply' ? 'promo_btn' : 'remove_promo_btn';
                const btn = document.getElementById(btnId);
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                }

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            ...data,
                            token
                        })
                    });

                    const result = await response.json();
                    if (!response.ok || !result.success) throw new Error(result.message || 'Operation failed');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message,
                        confirmButtonColor: '#6366f1',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => location.reload());

                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message,
                        confirmButtonColor: '#6366f1'
                    });
                    if (btn) btn.disabled = false;
                    if (btn) btn.innerHTML = action === 'apply' ? 'Terapkan' :
                        '<i class="ri-close-line mr-1"></i> Hapus';
                }
            }

            // ===============================
            // EVENT LISTENERS
            // ===============================
            document.querySelectorAll('#checkout-form input').forEach(input => input.addEventListener('input',
                saveFormData));
            document.getElementById('checkout-form').addEventListener('submit', clearFormData);

            const promoBtn = document.getElementById('promo_btn');
            const promoInput = document.getElementById('promo_code_input');
            if (promoBtn && promoInput) {
                promoBtn.addEventListener('click', () => {
                    if (!promoInput.value.trim()) return Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan masukkan kode promo',
                        confirmButtonColor: '#6366f1'
                    });
                    handlePromo('apply', {
                        promo_code: promoInput.value.trim()
                    });
                });
                promoInput.addEventListener('keypress', e => {
                    if (e.key === 'Enter') promoBtn.click();
                });
            }

            const removeBtn = document.getElementById('remove_promo_btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', () => {
                    Swal.fire({
                        title: 'Hapus Kode Promo?',
                        text: 'Apakah Anda yakin ingin menghapus kode promo ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#6366f1',
                        cancelButtonColor: '#ef4444',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then(result => {
                        if (result.isConfirmed) handlePromo('remove');
                    });
                });
            }

            cleanupOldStorage();
            restoreFormData();

        });
    </script>


@endsection
