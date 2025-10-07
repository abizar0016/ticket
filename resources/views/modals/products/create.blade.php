<div id="itemModal" class="fixed flex justify-center items-center inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                id="itemBackdrop"></div>
        </div>

        <!-- Modal Panel -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-xl transform transition-all sm:max-w-2xl w-full opacity-0 translate-y-4 scale-95"
            id="itemPanel" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="bg-white px-6 pt-6 pb-4 sm:p-6 max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-start gap-4">
                        <div id="itemTypeIcon"
                            class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
                            <i class="ri-ticket-2-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900" id="modalTitle">Add New Ticket</h3>
                            <p class="text-indigo-600/80 text-lg mt-1" id="modalSubtitle">Configure your item details
                            </p>
                        </div>
                    </div>
                    <button id="closeItemModal"
                        class="text-gray-400 hover:text-indigo-500 transition-colors duration-200 cursor-pointer">
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <!-- Form -->
                <form id="create-item-form" action="{{ route('products.store', ['id' => $events->id]) }}"
                    class="ajax-form" data-success="Item created successfully." method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="itemId" name="id">
                    <input type="hidden" id="itemType" name="type" value="ticket">
                    <input type="hidden" name="event_id" value="{{ $events->id }}">

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Type Toggle -->
                        <div class="flex rounded-lg border border-gray-200 bg-gray-50 p-1">
                            <button type="button"
                                class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 item-type-toggle bg-white shadow-sm text-indigo-600"
                                data-type="ticket">
                                <i class="ri-ticket-2-line mr-2"></i> Ticket
                            </button>
                            <button type="button"
                                class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 item-type-toggle text-gray-500"
                                data-type="merchandise">
                                <i class="ri-shopping-bag-3-line mr-2"></i> Merchandise
                            </button>
                        </div>

                        <!-- Title & Price -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                    <i id="titleIcon" class="ri-ticket-line text-xl"></i>
                                </div>
                                <input type="text" id="itemTitle" name="title"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="" required>
                                <label for="itemTitle"
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Item
                                    Name</label>
                            </div>

                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                    <i class="ri-money-dollar-circle-line text-xl"></i>
                                </div>
                                <input type="number" id="itemPrice" name="price"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="" min="0" step="0.01" required>
                                <label for="itemPrice"
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Price</label>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                <i class="ri-stack-line text-xl"></i>
                            </div>
                            <input type="number" id="itemQuantity" name="quantity"
                                class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                placeholder=" " value="" min="0">
                            <label for="itemQuantity"
                                class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Available
                                Quantity <span class="text-sm text-gray-400">(leave empty for unlimited)</span></label>
                        </div>

                        <div id="scanMode" class="mt-4">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Mode Scan</label>
                            <div class="flex gap-3">
                                <!-- Single Scan -->
                                <div class="flex flex-col gap-2 w-full">
                                    <button type="button" data-value="single"
                                        class="scan-toggle flex-1 py-3 px-4 rounded-lg border transition-colors duration-200 text-gray-700 bg-white border-gray-300 shadow-sm hover:bg-indigo-50 hover:border-indigo-400 hover:text-gray-700 font-medium flex items-center justify-center gap-2 active:bg-indigo-600 active:text-white cursor-pointer">
                                        <i class="ri-scan-line"></i>
                                        Single Scan
                                    </button>
                                    <p class="text-gray-500 text-xs mt-2">Single: tiket hanya bisa dipakai 1x</p>
                                </div>

                                <!-- Multi Scan -->
                                <div class="flex flex-col gap-2 w-full">
                                    <button type="button" data-value="multi"
                                        class="scan-toggle flex-1 py-3 px-4 rounded-lg border transition-colors duration-200 text-gray-700 bg-white border-gray-300 shadow-sm hover:bg-indigo-50 hover:border-indigo-400 hover:text-gray-700 font-medium flex items-center justify-center gap-2 active:bg-indigo-600 active:text-white cursor-pointer">
                                        <i class="ri-refresh-line"></i>
                                        Multi Scan
                                    </button>
                                    <p class="text-gray-500 text-xs mt-2">Multi: tiket bisa dipakai berkali-kali</p>
                                </div>
                            </div>
                            <input type="hidden" name="scan_mode" id="scanModeInput" value="single">
                        </div>

                        <script>
                            const scanButtons = document.querySelectorAll('.scan-toggle');
                            const scanInput = document.getElementById('scanModeInput');

                            scanButtons.forEach(btn => {
                                btn.addEventListener('click', () => {
                                    scanButtons.forEach(b => {
                                        b.classList.remove('bg-indigo-600', 'text-white');
                                        b.classList.add('bg-white', 'text-gray-700', 'hover:bg-indigo-50',
                                            'hover:border-indigo-400', 'hover:text-gray-700');
                                    });
                                    btn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-indigo-50',
                                        'hover:border-indigo-400', 'hover:text-gray-700');
                                    btn.classList.add('bg-indigo-600', 'text-white');
                                    scanInput.value = btn.getAttribute('data-value');
                                });
                            });
                        </script>

                        <!-- Min & Max per Order -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                    <i class="ri-number-1 text-xl"></i>
                                </div>
                                <input type="number" id="itemMinPerOrder" name="min_per_order" min="1"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="">
                                <label for="itemMinPerOrder"
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Min
                                    per order</label>
                            </div>

                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                    <i class="ri-number-9 text-xl"></i>
                                </div>
                                <input type="number" id="itemMaxPerOrder" name="max_per_order" min="1"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="">
                                <label for="itemMaxPerOrder"
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Max
                                    per order</label>
                            </div>
                        </div>

                        <!-- Sale Start & End Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                    <i class="ri-calendar-2-line text-xl"></i>
                                </div>
                                <input type="datetime-local" id="itemSaleStartDate" name="sale_start_date"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="" required>
                                <label for="itemSaleStartDate"
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Sale
                                    Start Date</label>
                            </div>

                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                    <i class="ri-calendar-check-line text-xl"></i>
                                </div>
                                <input type="datetime-local" id="itemSaleEndDate" name="sale_end_date"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="">
                                <label for="itemSaleEndDate"
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Sale
                                    End Date (optional)</label>
                            </div>
                        </div>

                        <!-- Description -->
                        <div id="descriptionContainer" class="relative group hidden">
                            <div class="absolute top-4 left-5 text-indigo-500">
                                <i class="ri-file-text-line text-xl"></i>
                            </div>
                            <textarea id="itemDescription" name="description" rows="4"
                                class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer resize-none"
                                placeholder=" "></textarea>
                            <label for="itemDescription"
                                class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Description</label>
                        </div>

                        <div class="relative hidden" id="imageContainer">
                            <label class="block text-gray-700 text-base font-medium mb-2">Item Image</label>
                            <div id="upload-container" class="group">
                                <!-- Default State -->
                                <div id="default-state"
                                    class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer transition-all duration-300 group-hover:border-indigo-400 group-hover:bg-indigo-50/30">
                                    <i class="ri-upload-cloud-2-line text-4xl text-indigo-500 mb-3"></i>
                                    <p class="font-semibold text-gray-700">Upload Item Image</p>
                                    <p class="text-sm text-gray-500 mt-1">PNG, JPG, GIF up to 10MB</p>
                                </div>

                                <!-- Preview State -->
                                <div id="preview-state"
                                    class="hidden relative w-full h-64 rounded-xl overflow-hidden border-2 border-gray-200">
                                    <img id="preview-image" class="w-full h-full object-cover" src=""
                                        alt="Image Preview">
                                    <div
                                        class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                        <button type="button" id="change-image"
                                            class="bg-white text-indigo-600 px-4 py-2 rounded-lg shadow-md font-medium hover:bg-indigo-50 transition-colors cursor-pointer">
                                            Change Image
                                        </button>
                                    </div>
                                </div>

                                <input id="file-upload" type="file" name="image" accept="image/*"
                                    class="hidden">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="bg-gray-50 px-1 py-4 sm:flex sm:flex-row-reverse rounded-b-xl mt-8">
                        <button type="submit" id="submitButton"
                            class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                            <i class="ri-add-line mr-2"></i> Create Item
                        </button>
                        <button type="button" id="cancelItemModal"
                            class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-semibold text-gray-700 hover:bg-gray-50 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto transition-all duration-300 cursor-pointer">
                            <i class="ri-close-line mr-2"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
