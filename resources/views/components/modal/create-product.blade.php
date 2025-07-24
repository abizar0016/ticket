<div id="itemModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        {{-- Backdrop --}}
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                id="itemBackdrop">
            </div>
        </div>

        {{-- Modal Panel --}}
        <div class="transition-all duration-300 opacity-0 translate-y-4 scale-95 transform sm:duration-500 sm:ease-in-out max-w-2xl w-full mx-auto z-50"
            id="itemPanel">

            <div class="bg-white rounded-4xl max-h-[90vh] overflow-y-auto px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-start justify-between">

                    <div>
                        <h3 class="text-2xl font-bold text-gray-900" id="modalTitle">Add New Item</h3>
                        <p class="text-sm text-gray-500 mt-1">Configure your item details</p>
                    </div>

                    <button id="closeItemModal"
                        class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                        <i class="ri-close-line text-2xl"></i>
                    </button>

                </div>

                <div class="mt-6">
                    <form id="create-product-form" action="{{ route('product.store', ['id' => $event->id]) }}"
                        method="POST" enctype="multipart/form-data" id="itemForm">
                        @csrf
                        <input type="hidden" id="itemId" name="id">
                        <input type="hidden" id="itemType" name="type" value="ticket">

                        <div class="grid grid-cols-1  gap-6">
                            {{-- Type Toggle --}}
                            <div class="flex rounded-lg border border-gray-200 bg-gray-50 p-1">
                                <button type="button"
                                    class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 item-type-toggle bg-white shadow-sm text-purple-600"
                                    data-type="ticket">
                                    <i class="ri-ticket-2-line mr-2"></i> Ticket
                                </button>
                                <button type="button"
                                    class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 item-type-toggle text-gray-500"
                                    data-type="product">
                                    <i class="ri-shopping-bag-3-line mr-2"></i> Merchandise
                                </button>
                            </div>

                            {{-- Name --}}
                            <div class="relative group">
                                <input type="text" id="itemTitle" name="title"
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                    placeholder=" " required>
                                <label for="itemTitle"
                                    class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                    Item Name
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                    <i class="ri-edit-box-line text-2xl"></i>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="relative group">
                                <textarea id="itemDescription" name="description" rows="3"
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 resize-y min-h-[100px] hover:min-h-[120px] focus:min-h-[120px] peer"
                                    placeholder=" " required></textarea>
                                <label for="itemDescription"
                                    class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                    Description
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-start pt-4 pointer-events-none text-purple-500">
                                    <i class="ri-align-left text-2xl"></i>
                                </div>
                            </div>

                            {{-- Price and Quantity --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Price --}}
                                <div class="relative group">
                                    <input type="number" id="itemPrice" name="price" min="0" step="0.01"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                        placeholder=" " required>
                                    <label for="itemPrice"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Price
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                        <i class="ri-money-dollar-circle-line text-2xl"></i>
                                    </div>
                                </div>

                                {{-- Quantity --}}
                                <div class="relative group">
                                    <input type="number" id="itemQuantity" name="quantity" min="1"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                        placeholder=" ">
                                    <label for="itemQuantity"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Quantity (optional)
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                        <i class="ri-inbox-archive-line text-2xl"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Order Limits --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Min per order --}}
                                <div class="relative group">
                                    <input type="number" id="itemMinPerOrder" name="min_per_order" min="1"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                        placeholder=" ">
                                    <label for="itemMinPerOrder"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Min per order
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                        <i class="ri-number-1 text-2xl"></i>
                                    </div>
                                </div>

                                {{-- Max per order --}}
                                <div class="relative group">
                                    <input type="number" id="itemMaxPerOrder" name="max_per_order" min="1"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                        placeholder=" ">
                                    <label for="itemMaxPerOrder"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Max per order
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                        <i class="ri-number-9 text-2xl"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Sales Period --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Start Date --}}
                                <div class="relative group">
                                    <input type="datetime-local" id="itemSaleStartDate" name="sale_start_date"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                        placeholder=" " required>
                                    <label for="itemSaleStartDate"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Sale Start Date
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                        <i class="ri-calendar-line text-2xl"></i>
                                    </div>
                                </div>

                                {{-- End Date --}}
                                <div class="relative group">
                                    <input type="datetime-local" id="itemSaleEndDate" name="sale_end_date"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                        placeholder=" ">
                                    <label for="itemSaleEndDate"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Sale End Date (optional)
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                        <i class="ri-calendar-check-line text-2xl"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Image Upload --}}
                            <div class="relative group">
                                <div id="itemUploadContainer"
                                    class="border-2 border-dashed border-gray-300 rounded-xl p-4 transition-all duration-300 hover:border-purple-400 bg-white cursor-pointer">
                                    <input type="file" id="itemFileUpload" name="image"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        accept="image/*">
                                    <div id="itemDefaultState"
                                        class="flex flex-col items-center justify-center gap-2 text-center py-4">
                                        <i class="ri-upload-cloud-2-line text-4xl text-purple-500"></i>
                                        <h4 class="font-medium text-gray-900">Upload Item Image</h4>
                                        <p class="text-sm text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                    </div>
                                    <div id="itemPreviewState" class="hidden flex-col items-center gap-4">
                                        <div class="w-full h-48 rounded-lg overflow-hidden border border-gray-200">
                                            <img id="itemPreviewImage" src="" alt="Preview Image"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <button type="button" id="itemChangeImage"
                                            class="text-sm text-red-600 hover:underline hover:text-red-800 transition-all duration-200">
                                            Change Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl mt-6">

                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-lg font-medium hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                                <i class="ri-add-line mr-2"></i> Create
                            </button>

                            <button type="button" id="cancelEventModal"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-lg font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300">
                                <i class="ri-close-line mr-2"></i> Cancel
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('create-product-form').addEventListener('submit', function(e) {
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
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                submitBtn.innerHTML = '<i class="ri-add-line mr-2"></i> Create';
            });
    });
</script>
