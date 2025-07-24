@foreach ($items as $item)
    <div id="itemUpdateModal-{{ $item->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Backdrop --}}
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                    id="itemUpdateBackdrop-{{ $item->id }}">
                </div>
            </div>

            {{-- Modal Panel --}}
            <div class="inline-block bg-white rounded-4xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full opacity-0 translate-y-4 sm:scale-95"
                id="itemUpdatePanel-{{ $item->id }}" role="dialog" aria-modal="true"
                aria-labelledby="modal-headline">

                <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4 max-h-[90vh] overflow-y-auto">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-3 rounded-xl bg-gradient-to-tr from-purple-500 to-indigo-600 text-white shadow-lg">
                                @if (($type ?? '') === 'ticket')
                                    <i class="ri-ticket-2-line text-2xl"></i>
                                @else
                                    <i class="ri-shirt-line text-2xl"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900" id="modal-headline">Update
                                    {{ ucfirst($type) }}</h3>
                                <p class="text-indigo-600/80 text-lg mt-1">Update {{ $type }} information</p>
                            </div>
                        </div>
                        <button id="closeItemUpdateModal-{{ $item->id }}"
                            class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    <div class="mt-6">
                        <form id="update-item-form-{{ $item->id }}" action="" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="type" value="{{ $type }}">

                            <div class="grid grid-cols-1 gap-6">
                                <div class="relative flex items-start gap-4">
                                    {{-- Title --}}
                                    <div class="relative flex-1 group">
                                        <input type="text" id="itemTitle" name="title"
                                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                            placeholder=" " value="{{ old('title', $item->title) }}" required>
                                        <label for="itemTitle"
                                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                            {{ ucfirst($type) }} Name
                                        </label>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                            <i
                                                class="ri-{{ $type === 'ticket' ? 'ticket' : 'product' }}-line text-2xl"></i>
                                        </div>
                                    </div>

                                    {{-- Price --}}
                                    <div class="relative flex-1 group">
                                        <input type="number" id="itemPrice" name="price"
                                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                            placeholder=" "
                                            value="{{ old('price', number_format($item->price, 0, ',', '.')) }}"
                                            required>
                                        <label for="itemPrice"
                                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                            Price
                                        </label>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                            <i class="ri-money-dollar-circle-line text-2xl"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- Quantity --}}
                                <div class="relative group">
                                    <input type="number" id="itemQuantity" name="quantity"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                        placeholder=" " value="{{ old('quantity', $item->quantity) }}">
                                    <label for="itemQuantity"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Available Quantity (leave empty for unlimited)
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                        <i class="ri-stack-line text-2xl"></i>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Start Date -->
                                    <div class="relative group">
                                        <input type="datetime-local" id="startDate" name="start_date"
                                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                            placeholder=" " value="{{ old('start_date', $item->sale_start_date) }}"
                                            required>
                                        <label for="startDate"
                                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                            Sale Start Date
                                        </label>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                            <i class="ri-calendar-2-line text-2xl"></i>
                                        </div>
                                    </div>

                                    <!-- End Date -->
                                    <div class="relative group">
                                        <input type="datetime-local" id="endDate" name="end_date"
                                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                            placeholder=" "value="{{ old('end_date', $item->sale_end_date) }}"
                                            required>
                                        <label for="endDate"
                                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                            Sale End Date
                                        </label>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                            <i class="ri-calendar-check-line text-2xl"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="relative group">
                                    <textarea id="itemDescription" name="description" rows="4"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                        placeholder=" " required>{{ old('description', $item->description) }}</textarea>
                                    <label for="itemDescription"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Description
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 pt-4 flex items-start pointer-events-none text-purple-500">
                                        <i class="ri-file-text-line text-2xl"></i>
                                    </div>
                                </div>

                                {{-- Image --}}
                                <div class="relative group">
                                    <div id="upload-container-{{ $item->id }}">
                                        <!-- Default State -->
                                        <div id="default-state-{{ $item->id }}"
                                            class="{{ $item->image ? 'hidden' : 'flex' }} flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                            <i class="ri-upload-cloud-2-line text-4xl text-purple-500"></i>
                                            <p class="font-semibold text-gray-700">Upload Event Image</p>
                                            <p class="text-sm text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                        </div>

                                        <!-- Preview State -->
                                        <div id="preview-state-{{ $item->id }}"
                                            class="{{ $item->image ? 'flex' : 'hidden' }} relative w-full h-auto rounded-lg overflow-hidden">
                                            <img id="preview-image-{{ $item->id }}" class="w-full object-cover"
                                                src="{{ asset($item->image) }}" alt="Image Preview">
                                            <button type="button" id="change-image-{{ $item->id }}"
                                                class="absolute top-2 right-2 bg-white/70 hover:bg-white text-sm px-3 py-1 rounded-md shadow">Change</button>
                                        </div>

                                        <input id="file-upload-{{ $item->id }}" type="file" name="image"
                                            accept="image/*" class="hidden">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl mt-6">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-lg font-medium hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                                    <i class="ri-save-line mr-2"></i> Update
                                </button>
                                <button type="button" id="cancelItemUpdateModal-{{ $item->id }}"
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
@endforeach
