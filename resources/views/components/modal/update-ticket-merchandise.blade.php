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
            <div class="inline-block bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full opacity-0 translate-y-4 sm:scale-95"
                id="itemUpdatePanel-{{ $item->id }}" role="dialog" aria-modal="true"
                aria-labelledby="modal-headline">

                <div class="bg-white px-6 pt-6 pb-4 sm:p-6 max-h-[90vh] overflow-y-auto">
                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
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
                            class="text-gray-400 hover:text-indigo-500 transition-colors duration-200 cursor-pointer">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    {{-- Form --}}
                    <form id="update-item-form-{{ $item->id }}" action="{{ route('product.update', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <input type="hidden" name="type" value="{{ $type }}">

                        <div class="grid grid-cols-1 gap-6">
                            {{-- Title and Price --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Title --}}
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-{{ $type === 'ticket' ? 'ticket' : 'product' }}-line text-xl"></i>
                                    </div>
                                    <input type="text" id="itemTitle-{{ $item->id }}" name="title"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                        placeholder=" " value="{{ old('title', $item->title) }}" required>
                                    <label for="itemTitle-{{ $item->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                        {{ ucfirst($type) }} Name
                                    </label>
                                </div>

                                {{-- Price --}}
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-money-dollar-circle-line text-xl"></i>
                                    </div>
                                    <input type="number" id="itemPrice-{{ $item->id }}" name="price"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                        placeholder=" "
                                        value="{{ old('price', $item->price) }}"
                                        min="0" step="0.01" required>
                                    <label for="itemPrice-{{ $item->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                        Price
                                    </label>
                                </div>
                            </div>

                            {{-- Quantity --}}
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                    <i class="ri-stack-line text-xl"></i>
                                </div>
                                <input type="number" id="itemQuantity-{{ $item->id }}" name="quantity"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" " value="{{ old('quantity', $item->quantity) }}" min="0">
                                <label for="itemQuantity-{{ $item->id }}"
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                    Available Quantity <span class="text-sm text-gray-400">(leave empty for unlimited)</span>
                                </label>
                            </div>

                            {{-- Date Range --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Start Date --}}
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-calendar-2-line text-xl"></i>
                                    </div>
                                    <input type="datetime-local" id="startDate-{{ $item->id }}" name="sale_start_date"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer datetime-input"
                                        placeholder=" " value="{{ old('start_date', $item->sale_start_date ? \Carbon\Carbon::parse($item->sale_start_date)->format('Y-m-d\TH:i') : '') }}"
                                        required>
                                    <label for="startDate-{{ $item->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                        Sale Start Date
                                    </label>
                                </div>

                                {{-- End Date --}}
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-calendar-check-line text-xl"></i>
                                    </div>
                                    <input type="datetime-local" id="endDate-{{ $item->id }}" name="sale_end_date"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer datetime-input"
                                        placeholder=" " value="{{ old('end_date', $item->sale_end_date ? \Carbon\Carbon::parse($item->sale_end_date)->format('Y-m-d\TH:i') : '') }}"
                                        required>
                                    <label for="endDate-{{ $item->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                        Sale End Date
                                    </label>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="relative group">
                                <div class="absolute top-4 left-5 text-indigo-500">
                                    <i class="ri-file-text-line text-xl"></i>
                                </div>
                                <textarea id="itemDescription-{{ $item->id }}" name="description" rows="4"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer resize-none"
                                    placeholder=" " required>{{ old('description', $item->description) }}</textarea>
                                <label for="itemDescription-{{ $item->id }}"
                                    class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                    Description
                                </label>
                            </div>

                            {{-- Image Upload --}}
                            <div class="relative">
                                <label class="block text-gray-700 text-base font-medium mb-2">Item Image</label>
                                <div id="upload-container-{{ $item->id }}" class="group">
                                    <!-- Default State -->
                                    <div id="default-state-{{ $item->id }}"
                                        class="{{ $item->image ? 'hidden' : 'flex' }} flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer transition-all duration-300 group-hover:border-indigo-400 group-hover:bg-indigo-50/30">
                                        <i class="ri-upload-cloud-2-line text-4xl text-indigo-500 mb-3"></i>
                                        <p class="font-semibold text-gray-700">Upload {{ ucfirst($type) }} Image</p>
                                        <p class="text-sm text-gray-500 mt-1">PNG, JPG, GIF up to 10MB</p>
                                    </div>

                                    <!-- Preview State -->
                                    <div id="preview-state-{{ $item->id }}"
                                        class="{{ $item->image ? 'block' : 'hidden' }} relative w-full h-64 rounded-xl overflow-hidden border-2 border-gray-200">
                                        <img id="preview-image-{{ $item->id }}" class="w-full h-full object-cover"
                                            src="{{ $item->image ? asset($item->image) : '' }}" alt="Image Preview">
                                        <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
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
                        </div>

                        {{-- Form Actions --}}
                        <div class="bg-gray-50 px-1 py-4 sm:flex sm:flex-row-reverse rounded-b-xl mt-8">
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                                <i class="ri-save-line mr-2"></i> Update {{ ucfirst($type) }}
                            </button>
                            <button type="button" id="cancelItemUpdateModal-{{ $item->id }}"
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
        
        if (form && form.id && form.id.startsWith('update-item-form-')) {
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
