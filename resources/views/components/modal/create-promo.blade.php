{{-- Add Promo Modal --}}
<div id="promoModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        {{-- Backdrop --}}
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-0 transition-opacity duration-300" id="promoBackdrop">
            </div>
        </div>

        {{-- Modal Panel --}}
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full opacity-0 translate-y-4 scale-95"
            id="promoPanel">
            <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900" id="promoModalTitle">Create New Promo Code</h3>
                        <p class="text-sm text-gray-500 mt-1">Set up discounts for your tickets</p>
                    </div>
                    <button id="closePromoModal"
                        class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <div class="mt-6">
                    <form id="create-promo-form" action="{{ route('promocode.store') }}" method="POST" id="promoForm">
                        @csrf
                        <input type="hidden" id="promoId" name="id">

                        <div class="grid grid-cols-1 gap-6">
                            {{-- Code --}}
                            <div class="relative group">
                                <input type="text" id="promoCode" name="code"
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                    placeholder=" " required>
                                <label for="promoCode"
                                    class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                    Promo Code
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                    <i class="ri-coupon-2-line text-2xl"></i>
                                </div>
                            </div>

                            {{-- Product Selection --}}
                            <div class="relative group">
                                <select id="promoProduct" name="product_id"
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer appearance-none"
                                    required>
                                    <option value="">Select a product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                                    @endforeach
                                </select>
                                <label for="promoProduct"
                                    class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                    Apply To Product
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                    <i class="ri-ticket-2-line text-2xl"></i>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="ri-arrow-down-s-line text-gray-400"></i>
                                </div>
                            </div>

                            {{-- Discount Type and Amount --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Discount Type --}}
                                <div class="relative group">
                                    <select id="promoType" name="type"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer appearance-none"
                                        required>
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed Amount</option>
                                    </select>
                                    <label for="promoType"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Discount Type
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                        <i class="ri-percent-line text-2xl"></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="ri-arrow-down-s-line text-gray-400"></i>
                                    </div>
                                </div>

                                {{-- Discount Amount --}}
                                <div class="relative group">
                                    <input type="number" id="promoDiscount" name="discount" min="1"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                        placeholder=" " required>
                                    <label for="promoDiscount"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Discount Amount
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                        <i class="ri-money-dollar-circle-line text-2xl"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Max Uses --}}
                            <div class="relative group">
                                <input type="number" id="promoMaxUses" name="max_uses" min="0"
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                    placeholder=" " required>
                                <label for="promoMaxUses"
                                    class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                    Max Uses
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                    <i class="ri-user-line text-2xl"></i>
                                </div>
                                <div class="absolute right-5 top-4 text-gray-500 text-lg">
                                    <span id="promoMaxUsesHelp">(0 for unlimited)</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl">
                            <button type="submit" id="submitPromoForm"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-lg font-medium hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                                Save Promo Code
                            </button>
                            <button type="button" id="cancelPromoModal"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-lg font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('create-promo-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');

        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

        fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async (res) => {
                const data = await res.json();

                if (res.ok && data.success) {
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
                        html: (data.errors || ['Something went wrong']).join("<br>"),
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
    });
</script>