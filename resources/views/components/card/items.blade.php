<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
    @foreach ($items as $item)
        @if($item->type === 'ticket')
            <!-- Ticket Card -->
            <div
                class="bg-white rounded-lg sm:rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md sm:hover:shadow-lg transition-all duration-300 group h-full flex flex-col relative">

                <!-- Status Ribbon -->
                <div class="absolute top-2 sm:top-3 right-2 sm:right-3 z-10">
                    <span
                        class="px-2 sm:px-3 py-0.5 sm:py-1 {{ $item->getStatusBadgeClass() }} text-xs font-semibold rounded-full shadow-sm">
                        {{ $item->getStatusText() }}
                    </span>
                </div>

                <!-- Ticket Content -->
                <div class="p-3 sm:p-4 md:p-5 flex-grow">
                    <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-3 line-clamp-1">
                        🎟️ {{ $item->title }}
                    </h3>

                    <!-- Price Section -->
                    <div class="mb-3 sm:mb-4">
                        <span class="text-lg sm:text-xl font-bold text-indigo-600">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </span>
                        <span class="text-gray-400 text-xs sm:text-sm ml-1">/ticket</span>
                    </div>

                    <!-- Stats Section -->
                    <div class="grid grid-cols-2 gap-2 sm:gap-3 text-xs">
                        <div class="bg-gray-50 rounded sm:rounded-lg p-1.5 sm:p-2 flex items-center">
                            <i class="ri-shopping-basket-line text-gray-400 mr-1 sm:mr-2 text-sm"></i>
                            <div>
                                <div class="text-gray-500">Sold</div>
                                <div class="font-semibold">{{ $item->total_sold ?? 0 }}</div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded sm:rounded-lg p-1.5 sm:p-2 flex items-center">
                            <i class="ri-inbox-line text-gray-400 mr-1 sm:mr-2 text-sm"></i>
                            <div>
                                <div class="text-gray-500">Stock</div>
                                <div class="font-semibold {{ ($item->quantity ?? 0) <= 0 ? 'text-red-500' : '' }}">
                                    @if (is_null($item->quantity))
                                        ∞
                                    @elseif(($item->quantity ?? 0) <= 0)
                                        Sold Out
                                    @else
                                        {{ $item->quantity }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded sm:rounded-lg p-1.5 sm:p-2 flex items-center col-span-2">
                            <i class="ri-calendar-line text-gray-400 mr-1 sm:mr-2 text-sm"></i>
                            <div>
                                <div class="text-gray-500">Available until</div>
                                <div class="font-semibold">
                                    {{ $item->sale_end_date?->format('M d, Y') ?? 'No limit' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="border-t border-gray-100 px-3 sm:px-4 md:px-5 py-2 sm:py-3 bg-gray-50 flex justify-between items-center">
                    <div class="text-xs text-gray-400">
                        Created {{ $item->created_at->diffForHumans() }}
                    </div>
                    <div class="flex space-x-1 sm:space-x-2">
                        <button id="open-item-update-modal-{{ $item->id }}"
                            class="p-1.5 sm:p-2 text-gray-400 hover:text-white hover:bg-indigo-500 rounded-full transition-all duration-200 cursor-pointer"
                            data-id="{{ $item->id }}" title="Edit">
                            <i class="ri-pencil-line text-sm sm:text-base"></i>
                        </button>
                        <form id="delete-product-{{ $item->id }}" action="{{ route('products.destroy', $item->id) }}"
                            class="ajax-form"
                            data-success="Ticket deleted successfully."
                            data-confirm="Are you sure you want to delete this ticket?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="confirmDelete('delete-product-{{ $item->id }}')"
                                class="p-1.5 sm:p-2 text-gray-400 hover:text-white hover:bg-red-500 rounded-full transition-all duration-200 cursor-pointer"
                                data-id="{{ $item->id }}" title="Delete">
                                <i class="ri-delete-bin-line text-sm sm:text-base"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- Product Card (default, pakai image & deskripsi) -->
            <div
                class="bg-white rounded-lg sm:rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md sm:hover:shadow-lg transition-all duration-300 group h-full flex flex-col relative">

                <!-- Status Ribbon -->
                <div class="absolute top-2 sm:top-3 right-2 sm:right-3 z-10">
                    <span
                        class="px-2 sm:px-3 py-0.5 sm:py-1 {{ $item->getStatusBadgeClass() }} text-xs font-semibold rounded-full shadow-sm">
                        {{ $item->getStatusText() }}
                    </span>
                </div>

                <!-- Product Image Full -->
                <div class="h-32 sm:h-36 md:h-40 w-full overflow-hidden rounded-t-lg sm:rounded-t-xl">
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover"
                        loading="lazy" />
                </div>

                <!-- Product Content -->
                <div class="p-3 sm:p-4 md:p-5 flex-grow">
                    <div class="flex justify-between items-start mb-2 sm:mb-3">
                        <h3 class="text-base sm:text-lg font-bold text-gray-800 line-clamp-1">{{ $item->title }}</h3>
                    </div>

                    <p class="text-gray-500 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">{{ $item->description }}</p>

                    <!-- Price Section -->
                    <div class="mb-3 sm:mb-4">
                        <span class="text-lg sm:text-xl font-bold text-indigo-600">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </span>
                        <span class="text-gray-400 text-xs sm:text-sm ml-1">/{{ $type }}</span>
                    </div>

                    <!-- Stats Section -->
                    <div class="grid grid-cols-2 gap-2 sm:gap-3 text-xs">
                        <div class="bg-gray-50 rounded sm:rounded-lg p-1.5 sm:p-2 flex items-center">
                            <i class="ri-shopping-basket-line text-gray-400 mr-1 sm:mr-2 text-sm"></i>
                            <div>
                                <div class="text-gray-500">Sold</div>
                                <div class="font-semibold">{{ $item->total_sold ?? 0 }}</div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded sm:rounded-lg p-1.5 sm:p-2 flex items-center">
                            <i class="ri-inbox-line text-gray-400 mr-1 sm:mr-2 text-sm"></i>
                            <div>
                                <div class="text-gray-500">Stock</div>
                                <div class="font-semibold {{ ($item->quantity ?? 0) <= 0 ? 'text-red-500' : '' }}">
                                    @if (is_null($item->quantity))
                                        ∞
                                    @elseif(($item->quantity ?? 0) <= 0)
                                        Sold Out
                                    @else
                                        {{ $item->quantity }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded sm:rounded-lg p-1.5 sm:p-2 flex items-center col-span-2">
                            <i class="ri-calendar-line text-gray-400 mr-1 sm:mr-2 text-sm"></i>
                            <div>
                                <div class="text-gray-500">Available until</div>
                                <div class="font-semibold">
                                    {{ $item->sale_end_date?->format('M d, Y') ?? 'No limit' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="border-t border-gray-100 px-3 sm:px-4 md:px-5 py-2 sm:py-3 bg-gray-50 flex justify-between items-center">
                    <div class="text-xs text-gray-400">
                        Created {{ $item->created_at->diffForHumans() }}
                    </div>
                    <div class="flex space-x-1 sm:space-x-2">
                        <button id="open-item-update-modal-{{ $item->id }}"
                            class="p-1.5 sm:p-2 text-gray-400 hover:text-white hover:bg-indigo-500 rounded-full transition-all duration-200 cursor-pointer"
                            data-id="{{ $item->id }}" title="Edit">
                            <i class="ri-pencil-line text-sm sm:text-base"></i>
                        </button>
                        <form id="delete-product-{{ $item->id }}" action="{{ route('products.destroy', $item->id) }}"
                            class="ajax-form"
                            data-success="Product deleted successfully."
                            data-confirm="Are you sure you want to delete this product?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="confirmDelete('delete-product-{{ $item->id }}')"
                                class="p-1.5 sm:p-2 text-gray-400 hover:text-white hover:bg-red-500 rounded-full transition-all duration-200 cursor-pointer"
                                data-id="{{ $item->id }}" title="Delete">
                                <i class="ri-delete-bin-line text-sm sm:text-base"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @include('modals.products.update')
    @endforeach
</div>
