<div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <!-- Dynamic Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Animated Header -->
        <div
            class="lg:col-span-12 relative overflow-hidden rounded-xl sm:rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 p-6 sm:p-8 mb-6 shadow-lg sm:shadow-2xl transition-all duration-500 hover:shadow-xl sm:hover:shadow-3xl group">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6">
                <div class="flex items-center gap-4 sm:gap-6">
                    <div
                        class="p-3 sm:p-4 rounded-lg sm:rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-md sm:shadow-lg">
                        <i class="ri-coupon-line text-2xl sm:text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">Promo Codes</h1>
                        <p class="text-indigo-600/80 text-base sm:text-lg mt-1 sm:mt-2">Manage discounts and special
                            offers</p>
                    </div>
                </div>
                <button id="openAddPromoModal"
                    class="relative z-10 px-3 sm:px-4 md:px-6 py-1.5 sm:py-2 md:py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg sm:rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 sm:hover:-translate-y-1 flex items-center justify-center gap-1 sm:gap-2 text-sm sm:text-base">
                    <i class="ri-add-line"></i>Create Promo
                </button>
            </div>
            <div class="absolute -right-6 -top-6 sm:-right-10 sm:-top-10 text-purple-100/40 text-7xl sm:text-9xl z-0">
                <i class="ri-coupon-3-fill"></i>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="lg:col-span-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
            <!-- Total Promos -->
            <div
                class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-md sm:shadow-lg border border-gray-100 transition-all duration-300 hover:shadow-lg sm:hover:shadow-xl hover:-translate-y-0.5 sm:hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Total Promo Codes</p>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">{{ $totalPromos }}</h3>
                    </div>
                    <div class="p-2 sm:p-3 rounded-md sm:rounded-lg bg-purple-100 text-purple-600">
                        <i class="ri-coupon-3-line text-xl sm:text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Active Promos -->
            <div
                class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-md sm:shadow-lg border border-gray-100 transition-all duration-300 hover:shadow-lg sm:hover:shadow-xl hover:-translate-y-0.5 sm:hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Active Promos</p>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">{{ $activePromos }}</h3>
                    </div>
                    <div class="p-2 sm:p-3 rounded-md sm:rounded-lg bg-green-100 text-green-600">
                        <i class="ri-checkbox-circle-line text-xl sm:text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Discounts -->
            <div
                class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-md sm:shadow-lg border border-gray-100 transition-all duration-300 hover:shadow-lg sm:hover:shadow-xl hover:-translate-y-0.5 sm:hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Total Discounts Given</p>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">
                            Rp {{ number_format($totalDiscounts, 0, ',', '.') }}
                        </h3>

                    </div>
                    <div class="p-2 sm:p-3 rounded-md sm:rounded-lg bg-blue-100 text-blue-600">
                        <i class="ri-money-dollar-circle-line text-xl sm:text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div
            class="lg:col-span-12 bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 mb-4 sm:mb-6 shadow-md sm:shadow-lg border border-gray-100">
            <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                <!-- Search -->
                <div class="relative flex-1 group">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500">
                        <i class="ri-search-line"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search promos..."
                        class="pl-10 pr-4 py-2 sm:py-2.5 border-2 border-gray-200 rounded-lg sm:rounded-xl focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none w-full transition-all duration-300 group-hover:border-indigo-300 text-sm sm:text-base">
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit"
                        class="px-3 sm:px-4 py-2 w-full md:w-auto rounded-lg sm:rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-xs sm:text-sm font-medium text-white hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 flex items-center justify-center gap-1 sm:gap-2">
                        <i class="ri-search-line text-sm sm:text-base"></i> Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Promo Codes Table -->
        <div
            class="lg:col-span-12 bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-md sm:shadow-lg border border-gray-100">
            <div
                class="px-4 py-3 sm:px-6 sm:py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
                <h3 class="text-base sm:text-lg font-bold text-gray-800">All Promo Codes</h3>
                <div class="text-xs sm:text-sm text-gray-500">
                    Showing {{ $promos->firstItem() }} to {{ $promos->lastItem() }} of {{ $promos->total() }} results
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-4 py-2 sm:px-6 sm:py-3 text-left text-xs sm:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th scope="col"
                                class="px-4 py-2 sm:px-6 sm:py-3 text-left text-xs sm:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Code</th>
                            <th scope="col"
                                class="px-4 py-2 sm:px-6 sm:py-3 text-left text-xs sm:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Discount</th>
                            <th scope="col"
                                class="px-4 py-2 sm:px-6 sm:py-3 text-left text-xs sm:text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                Applicable To</th>
                            <th scope="col"
                                class="px-4 py-2 sm:px-6 sm:py-3 text-left text-xs sm:text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                Uses</th>
                            <th scope="col"
                                class="px-4 py-2 sm:px-6 sm:py-3 text-left text-xs sm:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-4 py-2 sm:px-6 sm:py-3 text-right text-xs sm:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($promos as $promo)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10 bg-purple-100 rounded-md sm:rounded-lg flex items-center justify-center text-purple-600">
                                            <i class="ri-coupon-2-line text-sm sm:text-base"></i>
                                        </div>
                                        <div class="ml-3 sm:ml-4">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ Str::limit($promo->name, 15) }}
                                            </div>
                                            <div class="text-xs text-gray-500">Created:
                                                {{ $promo->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $promo->code }}</div>
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        @if ($promo->type === 'percentage')
                                            {{ $promo->discount }}% off
                                        @else
                                            Rp {{ number_format($promo->discount, 0, ',', '.') }} off
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                    <div class="flex flex-col gap-1">
                                        @if ($promo->is_ticket && $promo->is_merchandise)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                Ticket
                                            </span>
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                Merchandise
                                            </span>
                                        @elseif($promo->is_ticket)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                Ticket
                                            </span>
                                        @elseif($promo->is_merchandise)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                Merchandise
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                    <div class="flex items-center gap-2">
                                        <div class="w-12 sm:w-16 bg-gray-200 rounded-full h-1.5 sm:h-2">
                                            <div class="bg-indigo-500 h-1.5 sm:h-2 rounded-full"
                                                style="width: {{ $promo->max_uses > 0 ? min(100, ($promo->order_count / $promo->max_uses) * 100) : 100 }}%">
                                            </div>
                                        </div>
                                        <span class="text-xs sm:text-sm text-gray-900">
                                            {{ $promo->order_count }}
                                            @if ($promo->max_uses > 0)
                                                /{{ $promo->max_uses }}
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                    @if ($promo->max_uses == 0 || $promo->order_items_count < $promo->max_uses)
                                        <span
                                            class="px-2 py-0.5 sm:px-3 sm:py-1 inline-flex text-xs leading-4 font-medium rounded-full bg-green-100 text-green-800 flex items-center gap-1">
                                            <i class="ri-checkbox-circle-line text-xs sm:text-sm"></i> <span
                                                class="hidden sm:inline">Active</span>
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-0.5 sm:px-3 sm:py-1 inline-flex text-xs leading-4 font-medium rounded-full bg-red-100 text-red-800 flex items-center gap-1">
                                            <i class="ri-close-circle-line text-xs sm:text-sm"></i> <span
                                                class="hidden sm:inline">Used</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end items-center gap-1 sm:gap-2">
                                        <button onclick="openEditModal({{ $promo->id }})"
                                            class="p-1.5 sm:p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-md sm:rounded-lg transition-all duration-200"
                                            title="Edit">
                                            <i class="ri-edit-line text-sm sm:text-base"></i>
                                        </button>
                                        <form id="delete-promo-{{ $promo->id }}"
                                            action="{{ route('promocode.destroy', $promo->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete('delete-promo-{{ $promo->id }}')"
                                                class="p-1.5 sm:p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-md sm:rounded-lg transition-all duration-200"
                                                title="Delete">
                                                <i class="ri-delete-bin-line text-sm sm:text-base"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 sm:px-6 sm:py-4 border-t border-gray-200">
                {{ $promos->appends(['content' => 'promo-codes'])->links('pagination::default') }}
            </div>
        </div>
    </div>
</div>

@include('components.modal.create-promo')

<script>
    function confirmDelete(formId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the promo code. Do you want to proceed?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById(formId);
                const formData = new FormData(form);
                const actionUrl = form.getAttribute('action');
                const csrf = form.querySelector('input[name="_token"]').value;

                fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrf,
                        },
                    })
                    .then(async (res) => {
                        const data = await res.json();

                        if (res.ok && data.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#6366F1'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Oops!',
                                html: (data.errors || ['Failed to delete']).join("<br>"),
                                icon: 'error',
                                confirmButtonColor: '#EF4444'
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Something went wrong',
                            icon: 'error',
                            confirmButtonColor: '#EF4444'
                        });
                    });
            }
        });
    }
</script>
