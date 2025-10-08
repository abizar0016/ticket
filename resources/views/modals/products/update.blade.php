@foreach ($items as $item)
    <div id="itemUpdateModal-{{ $item->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto flex justify-center items-center">
        <div class="flex items-center justify-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                id="itemUpdateBackdrop-{{ $item->id }}" aria-hidden="true"></div>

            <!-- Modal Panel -->
            <div id="itemUpdatePanel-{{ $item->id }}"
                class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl transform transition-all sm:max-w-2xl w-full opacity-0 translate-y-4 scale-95 overflow-hidden">
                <div class="px-6 pt-6 pb-4 sm:p-6 max-h-[90vh] overflow-y-auto">

                    <!-- Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-4">
                            <div class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg shadow-indigo-500/20">
                                <i class="{{ $item->type === 'ticket' ? 'ri-ticket-2-line' : 'ri-shopping-bag-3-line' }} text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100" id="modal-headline">
                                    Update {{ ucfirst($item->type) }}
                                </h3>
                                <p class="text-indigo-600 dark:text-indigo-400 text-lg mt-1">
                                    Modify your item details
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('products.update', $item->id) }}" method="POST" class="ajax-form"
                        data-success="Item updated successfully." enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="event_id" value="{{ $events->id }}">
                        <input type="hidden" name="type" value="{{ $item->type }}">

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Title & Price -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                        <i class="{{ $item->type === 'ticket' ? 'ri-ticket-line' : 'ri-shirt-line' }} text-xl"></i>
                                    </div>
                                    <input type="text" name="title" value="{{ old('title', $item->title) }}" required
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-400 outline-none shadow-sm peer bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-transparent transition-all duration-300 group-hover:border-indigo-300"
                                        placeholder=" ">
                                    <label
                                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                        Item Name
                                    </label>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                        <i class="ri-money-dollar-circle-line text-xl"></i>
                                    </div>
                                    <input type="number" name="price" min="0" step="0.01"
                                        value="{{ old('price', $item->price) }}" required
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-400 outline-none shadow-sm peer bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-transparent transition-all duration-300 group-hover:border-indigo-300"
                                        placeholder=" ">
                                    <label
                                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                        Price
                                    </label>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-stack-line text-xl"></i>
                                </div>
                                <input type="number" name="quantity" min="0"
                                    value="{{ old('quantity', $item->quantity) }}"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-400 outline-none shadow-sm peer bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-transparent transition-all duration-300 group-hover:border-indigo-300"
                                    placeholder=" ">
                                <label
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                    Available Quantity <span class="text-sm text-gray-400">(leave empty for unlimited)</span>
                                </label>
                            </div>

                            <!-- Scan Mode -->
                            @if ($item->type === 'ticket')
                                <div id="scanMode-{{ $item->id }}" class="mt-4">
                                    <label class="block text-gray-500 dark:text-gray-400 text-sm font-semibold mb-2">Mode Scan</label>
                                    <div class="flex gap-3">
                                        <div class="flex flex-col gap-2 w-full">
                                            <button type="button" data-value="single"
                                                class="scan-toggle flex-1 py-3 px-4 rounded-lg border font-medium flex items-center justify-center gap-2 shadow-sm cursor-pointer transition-all duration-200
                                                {{ $item->scan_mode === 'single'
                                                    ? 'bg-indigo-600 text-white border-indigo-600'
                                                    : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-600 hover:bg-indigo-50 dark:hover:bg-indigo-600 hover:text-white hover:border-indigo-400' }}">
                                                <i class="ri-scan-line"></i> Single Scan
                                            </button>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">Single: tiket hanya bisa dipakai 1x</p>
                                        </div>
                                        <div class="flex flex-col gap-2 w-full">
                                            <button type="button" data-value="multi"
                                                class="scan-toggle flex-1 py-3 px-4 rounded-lg border font-medium flex items-center justify-center gap-2 shadow-sm cursor-pointer transition-all duration-200
                                                {{ $item->scan_mode === 'multi'
                                                    ? 'bg-indigo-600 text-white border-indigo-600'
                                                    : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-600 hover:bg-indigo-50 dark:hover:bg-indigo-600 hover:text-white hover:border-indigo-400' }}">
                                                <i class="ri-refresh-line"></i> Multi Scan
                                            </button>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">Multi: tiket bisa dipakai berkali-kali</p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="scan_mode" value="{{ $item->scan_mode }}">
                                </div>
                            @endif

                            <!-- Min & Max per Order -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach (['min_per_order' => 'Min per order', 'max_per_order' => 'Max per order'] as $field => $label)
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                            <i class="{{ $field === 'min_per_order' ? 'ri-number-1' : 'ri-number-9' }} text-xl"></i>
                                        </div>
                                        <input type="number" name="{{ $field }}" min="1"
                                            value="{{ old($field, $item->$field) }}"
                                            class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-400 outline-none shadow-sm peer bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-transparent transition-all duration-300 group-hover:border-indigo-300"
                                            placeholder=" ">
                                        <label
                                            class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Sale Dates -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach (['sale_start_date' => 'Sale Start Date', 'sale_end_date' => 'Sale End Date'] as $field => $label)
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                            <i class="{{ $field === 'sale_start_date' ? 'ri-calendar-2-line' : 'ri-calendar-check-line' }} text-xl"></i>
                                        </div>
                                        <input type="datetime-local" name="{{ $field }}"
                                            value="{{ $item->$field ? \Carbon\Carbon::parse($item->$field)->format('Y-m-d\TH:i') : '' }}"
                                            class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-400 outline-none shadow-sm peer bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-transparent transition-all duration-300 group-hover:border-indigo-300"
                                            placeholder=" ">
                                        <label
                                            class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            @if ($item->type !== 'ticket')
                                <!-- Description -->
                                <div class="relative group">
                                    <div class="absolute top-4 left-5 text-indigo-500 dark:text-indigo-400">
                                        <i class="ri-file-text-line text-xl"></i>
                                    </div>
                                    <textarea name="description" rows="4"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-400 outline-none shadow-sm peer bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-transparent resize-none transition-all duration-300 group-hover:border-indigo-300"
                                        placeholder=" ">{{ old('description', $item->description) }}</textarea>
                                    <label
                                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                        Description
                                    </label>
                                </div>

                                <!-- Image Upload -->
                                <div class="relative mt-4">
                                    <label class="block text-gray-700 dark:text-gray-400 text-base font-medium mb-2">Item Image</label>
                                    <div id="upload-container-{{ $item->id }}" class="group">
                                        <div id="default-state-{{ $item->id }}"
                                            class="{{ $item->image ? 'hidden' : 'flex' }} flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center cursor-pointer transition-all duration-300 hover:border-indigo-400 hover:bg-indigo-50/30 dark:hover:bg-indigo-900/30">
                                            <i class="ri-upload-cloud-2-line text-4xl text-indigo-500 dark:text-indigo-400 mb-3"></i>
                                            <p class="font-semibold text-gray-700 dark:text-gray-200">Upload {{ ucfirst($type) }} Image</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF up to 10MB</p>
                                        </div>

                                        <div id="preview-state-{{ $item->id }}"
                                            class="{{ $item->image ? 'block' : 'hidden' }} relative w-full h-64 rounded-xl overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                            <img id="preview-image-{{ $item->id }}" class="w-full h-full object-cover"
                                                src="{{ $item->image ? asset($item->image) : '' }}" alt="Image Preview">
                                            <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                                <button type="button" id="change-image-{{ $item->id }}"
                                                    class="bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 px-4 py-2 rounded-lg shadow-md font-medium hover:bg-indigo-50 dark:hover:bg-indigo-700 transition cursor-pointer">
                                                    Change Image
                                                </button>
                                            </div>
                                        </div>

                                        <input id="file-upload-{{ $item->id }}" type="file" name="image" accept="image/*" class="hidden">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="bg-white dark:bg-gray-800 py-4 sm:flex sm:justify-end rounded-b-xl mt-8">
                            <button type="button" id="cancelItemUpdateModal-{{ $item->id }}"
                                class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto transition-all duration-300 cursor-pointer">
                                <i class="ri-close-line mr-2"></i> Cancel
                            </button>
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                                <i class="ri-save-line mr-2"></i> Update Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach