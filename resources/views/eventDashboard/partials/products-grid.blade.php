<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($items as $item)
        <div
            class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 group">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold text-gray-800">{{ $item->title }}</h3>
                    <span class="px-3 py-1 {{ $item->getStatusBadgeClass() }} text-sm font-medium rounded-full">
                        {{ $item->getStatusText() }}
                    </span>
                </div>
                <p class="text-gray-600 mb-4">{{ $item->description }}</p>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="text-2xl font-bold text-gray-900">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </span>
                        <span class="text-gray-500 ml-1">per {{ $type }}</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        <i class="{{ $type === 'ticket' ? 'ri-user-line' : 'ri-shopping-basket-line' }} mr-1"></i>
                        {{ $item->total_sold ?? 0 }} sold
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                    <div>
                        <i class="ri-inbox-archive-line mr-1"></i>
                        <span>
                            @if (is_null($item->quantity))
                                Unlimited
                            @elseif (($item->quantity ?? 0) <= 0)
                                <span class="text-red-500 font-semibold">Sold Out</span>
                            @else
                                {{ max(0, $item->quantity) }} available
                            @endif
                        </span>
                    </div>
                    <div>
                        <i class="ri-calendar-line mr-1"></i>
                        <span>Until {{ $item->sale_end_date?->format('M d') ?? 'No end date' }}</span>
                    </div>
                </div>

            </div>
            <div
                class="border-t border-gray-100 px-6 py-3 bg-gray-50 flex justify-end space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <button id="open-item-update-modal"
                    class="text-gray-500 hover:text-purple-600 transition-colors duration-200 edit-item"
                    data-id="{{ $item->id }}">
                    <i class="ri-pencil-line"></i>
                </button>
                <form id="delete-product-{{ $item->id }}" action="{{ route('product.destroy', $item->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-gray-500 hover:text-red-600 transition-colors duration-200 delete-item"
                        data-id="{{ $item->id }}">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>

@include('components.modal.update-ticket-product')

<script>
    document.querySelectorAll('form[id^="delete-product-"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                    title: 'Are you sure?',
                    text: "This action will permanently delete the product and all related data, including order items and attendees associated with it. Are you sure you want to proceed?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData(form);
                        const submitBtn = form.querySelector('button[type="submit"]');
                        const actionUrl = form.getAttribute('action');

                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                        submitBtn.innerHTML =
                            '<i class="fas fa-spinner fa-spin mr-2"></i> Deleting...';

                        fetch(actionUrl, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]')
                                        .value,
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
                                        html: (data.errors || ['Failed to delete'])
                                            .join("<br>"),
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
                            })
                            .finally(() => {
                                submitBtn.disabled = false;
                                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                                submitBtn.innerHTML =
                                    '<i class="ri-delete-bin-line text-xl"></i>';
                            });
                    }
                });
        });
    });
</script>
