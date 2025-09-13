@foreach ($promos as $promo)
    <div id="promoUpdateModal-{{ $promo->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            {{-- Backdrop --}}
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                    id="promoUpdateBackdrop-{{ $promo->id }}"></div>
            </div>

            <!-- Modal Panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full opacity-0 translate-y-4 sm:scale-95"
                id="promoUpdatePanel-{{ $promo->id }}" role="dialog" aria-modal="true"
                aria-labelledby="modal-headline">

                <div class="bg-white px-6 pt-6 pb-4 sm:p-6">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
                                <i class="ri-percent-line text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900" id="modal-headline">Update Promo Code</h3>
                                <p class="text-indigo-600/80 text-lg mt-1">Update promo code information</p>
                            </div>
                        </div>
                        <button id="closePromoUpdateModal-{{ $promo->id }}"
                            class="text-gray-400 hover:text-indigo-500 transition-colors duration-200 cursor-pointer">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    <form id="update-promo-form-{{ $promo->id }}"
                        action="{{ route('promocode.update', $promo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name and Code Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-coupon-2-line text-xl"></i>
                                    </div>
                                    <input type="text" id="promoName-{{ $promo->id }}" name="name"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                        placeholder=" " value="{{ old('name', $promo->name) }}" required>
                                    <label for="promoName-{{ $promo->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                        Promo Name
                                    </label>
                                </div>

                                <!-- Code -->
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-hashtag text-xl"></i>
                                    </div>
                                    <input type="text" id="promoCode-{{ $promo->id }}" name="code"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                        placeholder=" " value="{{ old('code', $promo->code) }}" required>
                                    <label for="promoCode-{{ $promo->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                        Promo Code
                                    </label>
                                </div>
                            </div>

                            <!-- Discount and Max Uses Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Discount -->
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-money-dollar-circle-line text-xl"></i>
                                    </div>
                                    <input type="number" id="promoDiscount-{{ $promo->id }}" name="discount"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                        placeholder=" " value="{{ old('discount', $promo->discount) }}" required
                                        min="0" step="0.01">
                                    <label for="promoDiscount-{{ $promo->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                        Discount Amount
                                    </label>
                                </div>

                                <!-- Max Uses -->
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-group-line text-xl"></i>
                                    </div>
                                    <input type="number" id="promoMaxUses-{{ $promo->id }}" name="max_uses"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                        placeholder=" " value="{{ old('max_uses', $promo->max_uses) }}" min="0">
                                    <label for="promoMaxUses-{{ $promo->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                        Max Uses (0 = Unlimited)
                                    </label>
                                </div>
                            </div>


                            <!-- Discount Type -->
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                    <i class="ri-coupon-3-line text-xl"></i>
                                </div>
                                <select id="promoDiscountType-{{ $promo->id }}" name="type"
                                    class="w-full px-5 py-4 pl-14 pr-10 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer appearance-none"
                                    required>
                                    <option value="percentage" {{ $promo->type == 'percentage' ? 'selected' : '' }}>
                                        Percentage
                                    </option>
                                    <option value="fixed" {{ $promo->type == 'fixed' ? 'selected' : '' }}>
                                        Fixed Amount</option>
                                </select>
                                <label for="promoDiscountType-{{ $promo->id }}"
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                    Discount Type
                                </label>
                                <div
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                    <i class="ri-arrow-down-s-line text-xl"></i>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <label class="block text-base font-medium text-gray-700">Applicable To</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Ticket Checkbox --}}
                                    <label
                                        class="relative flex items-start p-4 rounded-xl border-2 border-gray-200 hover:border-indigo-300 transition-all duration-300 cursor-pointer has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50/50">
                                        <div class="flex items-center h-5">
                                            <input id="is_ticket-{{ $promo->id }}" name="is_ticket" type="checkbox"
                                                value="1" {{ $promo->is_ticket ? 'checked' : '' }}
                                                class="h-5 w-5 rounded border-2 border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-all duration-200 peer">
                                        </div>
                                        <div class="ml-3 flex flex-col">
                                            <span
                                                class="text-base font-medium text-gray-900 peer-checked:text-indigo-700">Tickets</span>
                                            <span class="text-sm text-gray-500 peer-checked:text-indigo-600">Apply
                                                discount
                                                to event tickets</span>
                                        </div>
                                        <div
                                            class="absolute top-4 right-4 text-indigo-600 opacity-0 peer-checked:opacity-100 transition-opacity duration-300">
                                            <i class="ri-checkbox-circle-fill text-xl"></i>
                                        </div>
                                    </label>

                                    {{-- Merchandise Checkbox --}}
                                    <label
                                        class="relative flex items-start p-4 rounded-xl border-2 border-gray-200 hover:border-indigo-300 transition-all duration-300 cursor-pointer has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50/50">
                                        <div class="flex items-center h-5">
                                            <input id="is_merchandise-{{ $promo->id }}" name="is_merchandise"
                                                type="checkbox" value="1"
                                                {{ $promo->is_merchandise ? 'checked' : '' }}
                                                class="h-5 w-5 rounded border-2 border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-all duration-200 peer">
                                        </div>
                                        <div class="ml-3 flex flex-col">
                                            <span
                                                class="text-base font-medium text-gray-900 peer-checked:text-indigo-700">Merchandise</span>
                                            <span class="text-sm text-gray-500 peer-checked:text-indigo-600">Apply
                                                discount
                                                to event merchandise</span>
                                        </div>
                                        <div
                                            class="absolute top-4 right-4 text-indigo-600 opacity-0 peer-checked:opacity-100 transition-opacity duration-300">
                                            <i class="ri-checkbox-circle-fill text-xl"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Usage Count (Read-only) -->
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                    <i class="ri-shopping-bag-line text-xl"></i>
                                </div>
                                <input type="text" id="promoUsageCount-{{ $promo->id }}"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 bg-gray-100 text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer cursor-not-allowed"
                                    placeholder=" " value="Used {{ $promo->order_count }} time(s)" readonly>
                                <label for="promoUsageCount-{{ $promo->id }}"
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                    Usage Count
                                </label>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-gray-50 px-1 py-4 sm:flex sm:flex-row-reverse rounded-b-xl mt-6">
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                                <i class="ri-save-line mr-2"></i> Update Promo Code
                            </button>
                            <button type="button" id="cancelPromoUpdateModal-{{ $promo->id }}"
                                class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-semibold text-gray-700 hover:bg-gray-50 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto transition-all duration-300 cursor-pointer">
                                <i class="ri-close-line mr-2"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    document.addEventListener('submit', function(e) {
        const form = e.target;

        if (form && form.id && form.id.startsWith('update-promo-form-')) {
            e.preventDefault();

            if (form.getAttribute('data-submitting') === 'true') {
                return;
            }

            form.setAttribute('data-submitting', 'true');

            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            submitBtn.innerHTML = '<i class="ri-loader-4-line animate-spin mr-2"></i> Saving...';

            fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                    }
                })
                .then(async (res) => {
                    const data = await res.json();

                    if (res.ok && data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#6366F1',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'rounded-lg px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white'
                            }
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        let errorMessage = 'Something went wrong';
                        if (data.message) {
                            errorMessage = data.message;
                        } else if (data.errors) {
                            errorMessage = Object.values(data.errors).join('<br>');
                        }

                        Swal.fire({
                            title: 'Oops!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonColor: '#EF4444',
                            confirmButtonText: 'Try Again',
                            customClass: {
                                confirmButton: 'rounded-lg px-4 py-2 bg-red-500 hover:bg-red-600 text-white'
                            }
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#EF4444',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'rounded-lg px-4 py-2 bg-red-500 hover:bg-red-600 text-white'
                        }
                    });
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML = originalText;
                    // Hapus tanda submitting
                    form.removeAttribute('data-submitting');
                });
        }
    });
</script>
