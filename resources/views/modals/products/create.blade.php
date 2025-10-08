<div id="itemModal" class="fixed flex justify-center items-center inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div id="itemBackdrop"
                class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
        </div>

        <!-- Modal Panel -->
        <div id="itemPanel"
            class="rounded-2xl overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl w-full opacity-0 translate-y-4 scale-95"
            role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4 sm:p-6 max-h-[90vh] overflow-y-auto">

                <!-- Header -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-start gap-4">
                        <div id="itemTypeIcon"
                            class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg shadow-indigo-500/20">
                            <i class="ri-ticket-2-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 id="modalTitle" class="text-2xl font-bold text-gray-900 dark:text-gray-100">Add New Ticket</h3>
                            <p id="modalSubtitle" class="text-indigo-600 dark:text-indigo-400 text-lg mt-1">
                                Configure your item details
                            </p>
                        </div>
                    </div>
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
                        <div class="flex rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 p-1">
                            <button type="button"
                                class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 item-type-toggle bg-white dark:bg-gray-800 shadow-sm text-indigo-600 dark:text-indigo-400 hover:shadow-md hover:border-indigo-300"
                                data-type="ticket">
                                <i class="ri-ticket-2-line mr-2"></i> Ticket
                            </button>
                            <button type="button"
                                class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 item-type-toggle text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-300"
                                data-type="merchandise">
                                <i class="ri-shopping-bag-3-line mr-2"></i> Merchandise
                            </button>
                        </div>

                        <!-- Inputs (unchanged logic, polished visuals) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i id="titleIcon" class="ri-ticket-line text-xl"></i>
                                </div>
                                <input type="text" id="itemTitle" name="title"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 outline-none transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " required>
                                <label for="itemTitle"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                    Item Name
                                </label>
                            </div>

                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-money-dollar-circle-line text-xl"></i>
                                </div>
                                <input type="number" id="itemPrice" name="price"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 outline-none transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " min="0" step="0.01" required>
                                <label for="itemPrice"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                    Price
                                </label>
                            </div>
                        </div>

                                                <!-- Quantity -->
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                <i class="ri-stack-line text-xl"></i>
                            </div>
                            <input type="number" id="itemQuantity" name="quantity"
                                class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 outline-none transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                placeholder=" " value="" min="0">
                            <label for="itemQuantity"
                                class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">Available
                                Quantity <span class="text-sm text-gray-400">(leave empty for unlimited)</span></label>
                        </div>

                        <div id="scanMode" class="mt-4">
                            <label class="block text-gray-500 dark:text-gray-400 text-sm font-semibold mb-2">Mode
                                Scan</label>
                            <div class="flex gap-3">
                                <!-- Single Scan -->
                                <div class="flex flex-col gap-2 w-full">
                                    <button type="button" data-value="single"
                                        class="scan-toggle flex-1 py-3 px-4 rounded-lg border transition-colors duration-200 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 shadow-sm hover:bg-indigo-50 dark:hover:bg-indigo-600 hover:border-indigo-400 hover:text-gray-700 dark:hover:text-gray-200 font-medium flex items-center justify-center gap-2 active:bg-indigo-600 active:text-white cursor-pointer">
                                        <i class="ri-scan-line"></i>
                                        Single Scan
                                    </button>
                                    <p class="text-gray-500 dark:text-gray-400 text-xs mt-2">Single: tiket hanya bisa
                                        dipakai 1x</p>
                                </div>

                                <!-- Multi Scan -->
                                <div class="flex flex-col gap-2 w-full">
                                    <button type="button" data-value="multi"
                                        class="scan-toggle flex-1 py-3 px-4 rounded-lg border transition-colors duration-200 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 shadow-sm hover:bg-indigo-50 dark:hover:bg-indigo-600 hover:border-indigo-400 hover:text-gray-700 dark:hover:text-gray-200 font-medium flex items-center justify-center gap-2 active:bg-indigo-600 active:text-white cursor-pointer">
                                        <i class="ri-refresh-line"></i>
                                        Multi Scan
                                    </button>
                                    <p class="text-gray-500 dark:text-gray-400 text-xs mt-2">Multi: tiket bisa dipakai
                                        berkali-kali</p>
                                </div>
                            </div>
                            <input type="hidden" name="scan_mode" id="scanModeInput" value="single">
                        </div>

                        <script>
                            const scanButtons = document.querySelectorAll('.scan-toggle');
                            const scanInput = document.getElementById('scanModeInput');

                            const activeClasses = ['bg-indigo-600', 'text-white', 'border-indigo-600'];
                            const inactiveClasses = [
                                'bg-white', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-200',
                                'border-gray-300', 'dark:border-gray-600',
                                'hover:bg-indigo-50', 'dark:hover:bg-indigo-600', 'hover:border-indigo-400'
                            ];

                            scanButtons.forEach(btn => {
                                btn.addEventListener('click', () => {
                                    // Reset semua tombol ke inactive
                                    scanButtons.forEach(b => {
                                        b.classList.remove(...activeClasses);
                                        b.classList.add(...inactiveClasses);
                                        b.setAttribute('aria-selected', 'false');
                                    });

                                    // Aktifkan tombol yang diklik
                                    btn.classList.remove(...inactiveClasses);
                                    btn.classList.add(...activeClasses);
                                    btn.setAttribute('aria-selected', 'true');

                                    // Update hidden input
                                    scanInput.value = btn.dataset.value;
                                });
                            });
                        </script>


                        <!-- Min & Max per Order -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-number-1 text-xl"></i>
                                </div>
                                <input type="number" id="itemMinPerOrder" name="min_per_order" min="1"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 outline-none transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="">
                                <label for="itemMinPerOrder"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">Min
                                    per order</label>
                            </div>

                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-number-9 text-xl"></i>
                                </div>
                                <input type="number" id="itemMaxPerOrder" name="max_per_order" min="1"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 outline-none transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="">
                                <label for="itemMaxPerOrder"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">Max
                                    per order</label>
                            </div>
                        </div>

                        <!-- Sale Start & End Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-calendar-2-line text-xl"></i>
                                </div>
                                <input type="datetime-local" id="itemSaleStartDate" name="sale_start_date"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 outline-none transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="" required>
                                <label for="itemSaleStartDate"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">Sale
                                    Start Date</label>
                            </div>

                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-calendar-check-line text-xl"></i>
                                </div>
                                <input type="datetime-local" id="itemSaleEndDate" name="sale_end_date"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 outline-none transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="">
                                <label for="itemSaleEndDate"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">Sale
                                    End Date (optional)</label>
                            </div>
                        </div>

                        <!-- Description -->
                        <div id="descriptionContainer" class="relative group hidden">
                            <div class="absolute top-4 left-5 text-indigo-500">
                                <i class="ri-file-text-line text-xl"></i>
                            </div>
                            <textarea id="itemDescription" name="description" rows="4"
                                class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 outline-none transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer resize-none"
                                placeholder=" "></textarea>
                            <label for="itemDescription"
                                class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">Description</label>
                        </div>

                        <div class="relative hidden" id="imageContainer">
                            <label class="block text-gray-700 dark:text-gray-400 text-base font-medium mb-2">Item Image</label>
                            <div id="upload-container" class="group">
                                <!-- Default State -->
                                <div id="default-state"
                                    class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer transition-all duration-300 group-hover:border-indigo-400 group-hover:bg-indigo-50/30">
                                    <i class="ri-upload-cloud-2-line text-4xl text-indigo-500 dark:text-indigo-400 mb-3"></i>
                                    <p class="font-semibold text-gray-700 dark:text-gray-100">Upload Item Image</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF up to 10MB</p>
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

                    <!-- Footer Buttons -->
                    <div class="bg-white dark:bg-gray-800 py-4 sm:flex sm:justify-end rounded-b-xl mt-8">
                        <button type="button" id="cancelItemModal"
                            class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto transition-all duration-300 cursor-pointer">
                            <i class="ri-close-line mr-2"></i> Cancel
                        </button>
                        <button type="submit" id="submitButton"
                            class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                            <i class="ri-add-line mr-2"></i> Create Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
