@foreach ($items as $item)
    <div id="itemUpdateModal-{{ $item->id }}"
        class="fixed flex justify-center items-center inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                    id="itemUpdateBackdrop-{{ $item->id }}"></div>
            </div>

            <!-- Modal Panel -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl transform transition-all sm:max-w-2xl w-full opacity-0 translate-y-4 scale-95"
                id="itemUpdatePanel-{{ $item->id }}" role="dialog" aria-modal="true"
                aria-labelledby="modal-headline">
                <div class="bg-white px-6 pt-6 pb-4 sm:p-6 max-h-[90vh] overflow-y-auto">

                    <!-- Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
                                <i
                                    class="{{ $item->type === 'ticket' ? 'ri-ticket-2-line' : 'ri-shopping-bag-3-line' }} text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900" id="modal-headline">Update
                                    {{ ucfirst($item->type) }}</h3>
                                <p class="text-indigo-600/80 text-lg mt-1">Modify your item details</p>
                            </div>
                        </div>
                        <button id="closeItemUpdateModal-{{ $item->id }}"
                            class="text-gray-400 hover:text-indigo-500 transition-colors duration-200 cursor-pointer">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
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
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500">
                                        <i
                                            class="{{ $item->type === 'ticket' ? 'ri-ticket-line' : 'ri-shirt-line' }} text-xl"></i>
                                    </div>
                                    <input type="text" name="title"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 shadow-sm peer"
                                        placeholder=" " value="{{ old('title', $item->title) }}" required>
                                    <label
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transform -translate-y-9 scale-90 bg-white peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Item
                                        Name</label>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500">
                                        <i class="ri-money-dollar-circle-line text-xl"></i>
                                    </div>
                                    <input type="number" name="price" min="0" step="0.01"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 shadow-sm peer"
                                        placeholder=" " value="{{ old('price', $item->price) }}" required>
                                    <label
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transform -translate-y-9 scale-90 bg-white peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Price</label>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500">
                                    <i class="ri-stack-line text-xl"></i>
                                </div>
                                <input type="number" name="quantity" min="0"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 shadow-sm peer"
                                    placeholder=" " value="{{ old('quantity', $item->quantity) }}">
                                <label
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transform -translate-y-9 scale-90 bg-white peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                    Available Quantity <span class="text-sm text-gray-400">(leave empty for
                                        unlimited)</span>
                                </label>
                            </div>

                            <!-- Scan Mode -->
                            @if ($item->type === 'ticket')
                                <div id="scanMode-{{ $item->id }}" class="mt-4">
                                    <label class="block text-gray-700 text-sm font-semibold mb-2">Mode Scan</label>
                                    <div class="flex gap-3">
                                        <!-- Single Scan -->
                                        <div class="flex flex-col gap-2 w-full">
                                            <button type="button" data-value="single"
                                                class="scan-toggle flex-1 py-3 px-4 rounded-lg border transition-colors duration-200 font-medium flex items-center justify-center gap-2 shadow-sm cursor-pointer
                {{ $item->scan_mode === 'single'
                    ? 'bg-indigo-600 text-white border-indigo-600'
                    : 'bg-white text-gray-700 border-gray-300 hover:bg-indigo-50 hover:border-indigo-400' }}">
                                                <i class="ri-scan-line"></i> Single Scan
                                            </button>
                                            <p class="text-gray-500 text-xs mt-2">Single: tiket hanya bisa dipakai 1x
                                            </p>
                                        </div>

                                        <!-- Multi Scan -->
                                        <div class="flex flex-col gap-2 w-full">
                                            <button type="button" data-value="multi"
                                                class="scan-toggle flex-1 py-3 px-4 rounded-lg border transition-colors duration-200 font-medium flex items-center justify-center gap-2 shadow-sm cursor-pointer
                {{ $item->scan_mode === 'multi'
                    ? 'bg-indigo-600 text-white border-indigo-600'
                    : 'bg-white text-gray-700 border-gray-300 hover:bg-indigo-50 hover:border-indigo-400' }}">
                                                <i class="ri-refresh-line"></i> Multi Scan
                                            </button>
                                            <p class="text-gray-500 text-xs mt-2">Multi: tiket bisa dipakai berkali-kali
                                            </p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="scan_mode" value="{{ $item->scan_mode }}">
                                </div>
                            @endif

                            <!-- Min & Max per Order -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-number-1 text-xl"></i>
                                    </div>
                                    <input type="number" id="itemMinPerOrder" name="min_per_order" min="1"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                        placeholder=" " value="{{ old('min_per_order', $item->min_per_order) }}">
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
                                        placeholder=" " value="{{ old('max_per_order', $item->max_per_order) }}">
                                    <label for="itemMaxPerOrder"
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">Max
                                        per order</label>
                                </div>
                            </div>

                            <!-- Sale Dates -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500">
                                        <i class="ri-calendar-2-line text-xl"></i>
                                    </div>
                                    <input type="datetime-local" name="sale_start_date"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 shadow-sm peer"
                                        value="{{ $item->sale_start_date ? \Carbon\Carbon::parse($item->sale_start_date)->format('Y-m-d\TH:i') : '' }}"
                                        required>
                                    <label
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transform -translate-y-9 scale-90 bg-white peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:text-indigo-600 font-medium">Sale
                                        Start Date</label>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500">
                                        <i class="ri-calendar-check-line text-xl"></i>
                                    </div>
                                    <input type="datetime-local" name="sale_end_date"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 shadow-sm peer"
                                        value="{{ $item->sale_end_date ? \Carbon\Carbon::parse($item->sale_end_date)->format('Y-m-d\TH:i') : '' }}">
                                    <label
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transform -translate-y-9 scale-90 bg-white peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:text-indigo-600 font-medium">Sale
                                        End Date</label>
                                </div>
                            </div>

                            @if ($item->type !== 'ticket')
                                <!-- Description -->
                                <div class="relative group">
                                    <div class="absolute top-4 left-5 text-indigo-500">
                                        <i class="ri-file-text-line text-xl"></i>
                                    </div>
                                    <textarea name="description" rows="4"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 shadow-sm peer resize-none"
                                        placeholder=" ">{{ old('description', $item->description) }}</textarea>
                                    <label
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transform -translate-y-9 scale-90 bg-white peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:text-indigo-600 font-medium">Description</label>
                                </div>

                                {{-- Image Upload --}}
                                <div class="relative">
                                    <label class="block text-gray-700 text-base font-medium mb-2">Item Image</label>
                                    <div id="upload-container-{{ $item->id }}" class="group">
                                        <!-- Default State -->
                                        <div id="default-state-{{ $item->id }}"
                                            class="{{ $item->image ? 'hidden' : 'flex' }} flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer transition-all duration-300 group-hover:border-indigo-400 group-hover:bg-indigo-50/30">
                                            <i class="ri-upload-cloud-2-line text-4xl text-indigo-500 mb-3"></i>
                                            <p class="font-semibold text-gray-700">Upload {{ ucfirst($type) }} Image
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">PNG, JPG, GIF up to 10MB</p>
                                        </div>

                                        <!-- Preview State -->
                                        <div id="preview-state-{{ $item->id }}"
                                            class="{{ $item->image ? 'block' : 'hidden' }} relative w-full h-64 rounded-xl overflow-hidden border-2 border-gray-200">
                                            <img id="preview-image-{{ $item->id }}"
                                                class="w-full h-full object-cover"
                                                src="{{ $item->image ? asset($item->image) : '' }}"
                                                alt="Image Preview">
                                            <div
                                                class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                                <button type="button" id="change-image-{{ $item->id }}"
                                                    class="bg-white text-indigo-600 px-4 py-2 rounded-lg shadow-md font-medium hover:bg-indigo-50 transition-colors cursor-pointer">
                                                    Change Image
                                                </button>
                                            </div>
                                        </div>

                                        <input id="file-upload-{{ $item->id }}" type="file" name="image"
                                            accept="image/*" class="hidden">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="bg-gray-50 px-1 py-4 sm:flex sm:flex-row-reverse rounded-b-xl mt-8">
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition">
                                <i class="ri-save-line mr-2"></i> Update Item
                            </button>
                            <button type="button" id="cancelItemUpdateModal-{{ $item->id }}"
                                class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-semibold text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto transition">
                                <i class="ri-close-line mr-2"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
