<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-3 sm:p-4 md:p-6">
    <!-- Header Section -->
    <div
        class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-gray-700 dark:to-gray-800 p-8 mb-8 shadow-lg transition-all duration-500 hover:shadow-xl">
        <div class="flex items-center gap-6 z-10 relative">
            <div class="p-4 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
                <i class="ri-bill-line text-3xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">Event Orders</h1>
                <p class="text-indigo-600/80 dark:text-indigo-300/80 text-lg mt-2">Manage all event orders and payments
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-1">{{ $events->title }}</h2>
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ $events->start_date->translatedFormat('l, d F Y H:i') }} WIB -
                            {{ $events->end_date->translatedFormat('l, d F Y H:i') }} WIB
                        </p>
                    </div>
                    <span
                        class="px-3 py-1 rounded-full text-sm font-medium 
                        @if ($order->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 
                        @else
                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <!-- Order Items -->
                <div class="mb-8">
                    <h3
                        class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                        Order Items</h3>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between items-start p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-gray-100">{{ $item->product->title }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Quantity: {{ $item->quantity }}
                                    </p>
                                    @if ($item->promo_id)
                                        <p class="text-sm text-green-600 dark:text-green-400 mt-1">
                                            <i class="ri-coupon-line"></i> Promo Applied
                                        </p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    @if ($item->price_before_discount != $item->total_price)
                                        <p class="text-sm text-gray-400 line-through">Rp
                                            {{ number_format($item->price_before_discount, 0, ',', '.') }}</p>
                                    @endif
                                    <p class="font-medium text-gray-800 dark:text-gray-100">Rp
                                        {{ number_format($item->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Order Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Subtotal</span>
                            <span class="font-medium text-gray-800 dark:text-gray-100">Rp
                                {{ number_format($order->items->sum('total_price'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Discount</span>
                            <span class="font-medium text-green-600 dark:text-green-400">- Rp
                                {{ number_format($order->items->sum('price_before_discount') - $order->items->sum('total_price'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 pt-3">
                            <span class="text-gray-800 dark:text-gray-100 font-semibold">Total</span>
                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Proof -->
                @if ($order->payment_proof)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6 flex flex-col items-center">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Payment Proof</h3>

                        <img src="{{ asset($order->payment_proof) }}" alt="Payment Proof"
                            class="w-full max-w-xs rounded shadow cursor-pointer hover:opacity-90 transition"
                            id="paymentPreview">
                    </div>

                    <!-- Fullscreen overlay -->
                    <div id="fullscreenImage"
                        class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">

                        <!-- Tombol Close -->
                        <button class="absolute top-5 right-5 text-white text-3xl font-bold z-50 cursor-pointer"
                            onclick="hideFullscreen()">
                            &times;
                        </button>

                        <img src="{{ asset($order->payment_proof) }}"
                            class="max-w-full max-h-[90vh] rounded-lg shadow-xl transition-transform duration-300"
                            alt="Full Payment Proof">
                    </div>
                @endif
            </div>

            <!-- Attendees -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Attendees
                    ({{ $order->attendees->count() }})</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                                    Name</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                                    Ticket</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                                    Status</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                                    Ticket Code</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($order->attendees as $attendee)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-medium">
                                                {{ substr($attendee->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800 dark:text-gray-100">
                                                    {{ $attendee->name }}</div>
                                                <div class="text-gray-500 dark:text-gray-400 text-sm">
                                                    {{ $attendee->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                        {{ $attendee->product->title }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if ($attendee->status === 'used')
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 font-medium">Used</span>
                                        @elseif($attendee->status === 'active')
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 font-medium">Active</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 font-medium">Pending</span>
                                        @endif
                                    </td>
                                    <td
                                        class="px-4 py-3 whitespace-nowrap text-gray-600 dark:text-gray-300 font-mono flex items-center gap-2">
                                        <span>{{ $attendee->ticket_code ?? 'N/A' }}</span>
                                        @if ($attendee->ticket_code)
                                            <img src="{{ $attendee->url_qrcode }}" alt="QR Code" class="h-8 w-8" />
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer & Payment Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Customer Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Customer Information</h3>
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 flex items-center justify-center text-white font-bold">
                        {{ substr($order->name, 0, 1) }}{{ substr(strstr($order->name, ' '), 1, 1) ?? '' }}
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800 dark:text-gray-100">{{ $order->name }}</h4>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $order->email }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Order Date</p>
                        <p class="text-gray-800 dark:text-gray-100">
                            {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">User ID</p>
                        <p class="text-gray-800 dark:text-gray-100">{{ $order->user_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                        <p class="text-gray-800 dark:text-gray-100">
                            <a href="https://wa.me/{{ $order->phone }}" target="_blank" class="hover:underline">{{ $order->phone ?? '-' }}</a>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tipe Identitas</p>
                        <p class="text-gray-800 dark:text-gray-100">{{ $order->identity_type ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nomor Identitas</p>
                        <p class="text-gray-800 dark:text-gray-100">{{ $order->identity_number ?? '-' }}</p>
                    </div>
                </div>

            </div>

            <!-- Payment Status -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Payment Status</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-300">Status</span>
                        <span
                            class="font-medium @if ($order->status === 'paid') text-green-600 dark:text-green-400 @else text-yellow-600 dark:text-yellow-400 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    @if ($order->status === 'paid')
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-300">Paid At</span>
                            <span class="font-medium text-gray-800 dark:text-gray-100">
                                {{ $order->updated_at->format('F j, Y \a\t g:i A') }}
                            </span>
                        </div>
                    @endif

                    <div class="pt-4">
                        @if ($order->status === 'pending')
                            <form id="mark-as-paid-{{ $order->id }}" class="ajax-form"
                                data-success="Order marked as paid successfully."
                                data-confirm="Are you sure you want to mark this order as paid?"
                                action="{{ route('orders.mark-as-paid', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                                    Mark as Paid
                                </button>
                            </form>
                        @else
                            <form id="mark-as-pending-{{ $order->id }}" class="ajax-form"
                                data-success="Order marked as pending successfully."
                                data-confirm="Are you sure you want to mark this order as pending?"
                                action="{{ route('orders.mark-as-pending', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                                    Mark as Pending
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const overlay = document.getElementById('fullscreenImage');
    const preview = document.getElementById('paymentPreview');

    if (preview && overlay) {
        preview.addEventListener('click', () => {
            overlay.classList.remove('hidden');
        });

        overlay.addEventListener('click', function() {
            hideFullscreen();
        });
    }

    function hideFullscreen() {
        overlay?.classList.add('hidden');
    }

    if (overlay) {
        overlay.addEventListener('click', function() {
            hideFullscreen();
        });
    }


    // Mark as Paid
    document.querySelectorAll('form[id^="mark-as-paid-"]').forEach(form => {
        console.log('Found Mark as Paid form:', form);
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This will mark this order as paid. Do you want to proceed?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const actionUrl = form.getAttribute('action');
                    const formData = new FormData(form);

                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

                    fetch(actionUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]')
                                    .value,
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonColor: '#6366F1'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Oops!',
                                    html: (data.errors || ['Something went wrong'])
                                        .join("<br>"),
                                    icon: 'error',
                                    confirmButtonColor: '#EF4444'
                                });
                            }
                        })
                        .catch(() => {
                            Swal.fire({
                                title: 'Oops!',
                                text: 'Something went wrong (network or server error)',
                                icon: 'error',
                                confirmButtonColor: '#EF4444'
                            });
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                            submitBtn.innerHTML = 'Mark as Paid';
                        });
                }
            })
        });
    });

    // Mark as Pending
    document.querySelectorAll('form[id^="mark-as-pending-"]').forEach(form => {
        console.log('Found Mark as Pending form:', form);
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This will mark this order as pending. Do you want to proceed?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const actionUrl = form.getAttribute('action');
                    const formData = new FormData(form);

                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

                    fetch(actionUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]')
                                    .value,
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonColor: '#6366F1'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Oops!',
                                    html: (data.errors || ['Something went wrong'])
                                        .join("<br>"),
                                    icon: 'error',
                                    confirmButtonColor: '#EF4444'
                                });
                            }
                        })
                        .catch(() => {
                            Swal.fire({
                                title: 'Oops!',
                                text: 'Something went wrong (network or server error)',
                                icon: 'error',
                                confirmButtonColor: '#EF4444'
                            });
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                            submitBtn.innerHTML = 'Mark as Pending';
                        });
                }
            })
        });
    });
</script>
