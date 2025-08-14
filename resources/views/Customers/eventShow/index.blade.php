<!DOCTYPE html>
<html lang="en">
@include('components.head.head')

<body class="bg-gray-50">
    @include('components.navbar.navbar')
    @include('components.preloader.preloader')

    <main class="event-show-page overflow-hidden">
        <!-- Hero Section with Parallax Effect -->
        <section class="event-hero w-full h-screen bg-cover bg-center relative overflow-hidden group"
            style="background-image: url('{{ asset($event->event_image) }}')">
            <!-- Animated Gradient Overlay -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent z-0 opacity-100 group-hover:opacity-90 transition-opacity duration-1000">
            </div>

            <div class="h-full flex justify-center items-center relative z-10 px-4">
                <div
                    class="hero-content max-w-4xl text-center transform transition-all duration-700 group-hover:scale-[1.01]">

                    <h1 class="event-title text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-8 leading-tight tracking-tighter"
                        style="text-shadow: 4px 8px 4px rgba(0, 0, 0, 0.5)">
                        {{ $event->title }}
                    </h1>

                    <!-- Meta information with animated icons -->
                    <div class="event-meta flex flex-wrap justify-center gap-6 mb-10">
                        <div
                            class="meta-item flex items-center text-white/90 group-hover:text-white transition-colors duration-300">
                            <div
                                class="icon-container w-10 h-10 bg-primary-500/20 rounded-full flex items-center justify-center mr-3 group-hover:bg-primary-500/30 transition-all duration-300">
                                <i
                                    class="fas fa-calendar-alt text-primary-300 group-hover:text-primary-200 transition-colors duration-300"></i>
                            </div>
                            <span class="font-medium tracking-wide">
                                {{ $event->start_date->format('M d, Y') }} @if ($event->end_date)
                                    - {{ $event->end_date->format('M d, Y') }}
                                @endif
                            </span>
                        </div>
                        <div
                            class="meta-item flex items-center text-white/90 group-hover:text-white transition-colors duration-300">
                            <div
                                class="icon-container w-10 h-10 bg-primary-500/20 rounded-full flex items-center justify-center mr-3 group-hover:bg-primary-500/30 transition-all duration-300">
                                <i
                                    class="fas fa-map-marker-alt text-primary-300 group-hover:text-primary-200 transition-colors duration-300"></i>
                            </div>
                            <span class="font-medium tracking-wide">
                                {{ $event->location->venue_name ?? 'Online Event' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Scroll Indicator (Remix Icon) -->
            <div class="absolute bottom-16 left-1/2 transform -translate-x-1/2 z-10">
                <a href="#event-content" class="flex flex-col items-center group animate-bounce">
                    <span
                        class="text-gray-300 text-sm mb-2 group-hover:text-primary-600 transition-colors duration-300">
                        EXPLORE
                    </span>
                    <i
                        class="ri-arrow-down-line text-2xl text-gray-300 group-hover:text-primary-600 transition-colors duration-300"></i>
                </a>
            </div>
        </section>

        <!-- Event Content Section -->
        <section id="event-content" class="relative bg-white text-gray-900 py-24 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-white via-gray-100 to-gray-200 opacity-70 z-0"></div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">
                        About {{ $event->title }}
                    </h2>
                    <p class="text-xl leading-relaxed">
                        {{ $event->description ?? 'Event description will appear here...' }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Tickets & Products Section -->
        <section class="relative bg-white text-gray-900 py-24 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-white via-gray-100 to-gray-200 opacity-70 z-0"></div>

            <div class="container mx-auto px-4 sm:px-6 relative z-10">
                <div class="text-center mb-8 md:mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-3 md:mb-4">
                        Tickets & Merchandise
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto px-4">
                        Choose from our selection of tickets and exclusive event merchandise
                    </p>
                </div>

                <div class="max-w-6xl mx-auto">
                    <form action="{{ route('checkout') }}" method="POST" id="order-form"
                        class="flex flex-col lg:grid lg:grid-cols-2 gap-6 md:gap-8">
                        @csrf
                        <!-- Tickets Column -->
                        <div class="tickets-column">
                            <div class="flex items-center mb-4 md:mb-6">
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center">
                                    <span
                                        class="w-6 h-6 md:w-8 md:h-8 bg-primary-500 rounded-full flex items-center justify-center text-white mr-2 md:mr-3 text-sm md:text-base">1</span>
                                    Select Tickets
                                </h3>
                                <div
                                    class="ml-auto px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-xs md:text-sm font-medium">
                                    Required
                                </div>
                            </div>

                            <div class="space-y-3 md:space-y-4">
                                @forelse ($event->products->where('type', 'ticket') as $ticket)
                                    <input type="hidden" name="tickets[{{ $ticket->id }}]" value="0">

                                    <div
                                        class="ticket-card group relative bg-white rounded-lg md:rounded-xl shadow-sm hover:shadow-md border border-gray-200 hover:border-primary-300 transition-all duration-300 overflow-hidden">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-white to-primary-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                        </div>
                                        <div class="relative z-10 p-4 md:p-6 flex flex-col sm:flex-row">
                                            <div class="flex-shrink-0 mb-3 sm:mb-0 sm:mr-4 md:mr-5">
                                                <img src="{{ asset($ticket->image) }}" alt="{{ $ticket->title }}"
                                                    class="w-full sm:w-20 md:w-24 h-auto sm:h-20 md:h-24 object-cover rounded-lg shadow-inner mx-auto sm:mx-0">
                                            </div>
                                            <div class="flex-grow">
                                                <div
                                                    class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                                    <div class="mb-2 sm:mb-0">
                                                        <h4 class="text-base md:text-lg font-bold text-gray-900">
                                                            {{ $ticket->title }}</h4>
                                                        <p class="text-xs md:text-sm text-gray-500 mt-1">
                                                            General admission ticket
                                                        </p>
                                                    </div>
                                                    <div class="text-left sm:text-right">
                                                        <p class="text-lg md:text-xl font-bold text-primary-600">Rp
                                                            {{ number_format($ticket->price, 0, ',', '.') }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">{{ $ticket->quantity }}
                                                            available</p>
                                                    </div>
                                                </div>

                                                <div
                                                    class="mt-3 md:mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                                                    <div class="text-xs md:text-sm text-gray-600">
                                                        <i class="ri-ticket-2-line mr-1 text-primary-500"></i> General
                                                        Admission
                                                    </div>
                                                    <div
                                                        class="quantity-selector flex items-center justify-end sm:justify-start space-x-2">
                                                        <button type="button"
                                                            class="quantity-btn w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full transition-colors duration-200 quantity-decrease"
                                                            data-id="{{ $ticket->id }}">
                                                            <i class="fas fa-minus text-xs text-gray-600"></i>
                                                        </button>
                                                        <input type="number" id="quantity-{{ $ticket->id }}"
                                                            name="tickets[{{ $ticket->id }}]" value="0"
                                                            min="0" max="{{ $ticket->quantity }}"
                                                            class="quantity-input w-10 md:w-12 text-center border border-gray-300 rounded-md py-1 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm md:text-base">
                                                        <button type="button"
                                                            class="quantity-btn w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full transition-colors duration-200 quantity-increase"
                                                            data-id="{{ $ticket->id }}">
                                                            <i class="fas fa-plus text-xs text-gray-600"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 md:py-10">
                                        <div class="text-gray-400 mb-3 md:mb-4">
                                            <i class="fas fa-ticket-alt text-3xl md:text-4xl"></i>
                                        </div>
                                        <p class="text-gray-500 text-sm md:text-base">No tickets available at this time
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Merchandise Column -->
                        <div class="merchandise-column mt-6 md:mt-0">
                            <div class="flex items-center mb-4 md:mb-6">
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center">
                                    <span
                                        class="w-6 h-6 md:w-8 md:h-8 bg-primary-500 rounded-full flex items-center justify-center text-white mr-2 md:mr-3 text-sm md:text-base">2</span>
                                    Add Merchandise
                                </h3>
                                <div
                                    class="ml-auto px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-xs md:text-sm font-medium">
                                    Optional
                                </div>
                            </div>

                            <div class="space-y-3 md:space-y-4">
                                @forelse ($event->products->where('type', '!=', 'ticket') as $product)
                                    <input type="hidden" name="merchandise[{{ $product->id }}]" value="0">

                                    <div
                                        class="product-card group relative bg-white rounded-lg md:rounded-xl shadow-sm hover:shadow-md border border-gray-200 hover:border-primary-300 transition-all duration-300 overflow-hidden">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-white to-primary-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                        </div>
                                        <div class="relative z-10 p-4 md:p-6 flex flex-col sm:flex-row">
                                            <div class="flex-shrink-0 mb-3 sm:mb-0 sm:mr-4 md:mr-5">
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->title }}"
                                                    class="w-full sm:w-20 md:w-24 h-auto sm:h-20 md:h-24 object-cover rounded-lg shadow-inner mx-auto sm:mx-0">
                                            </div>
                                            <div class="flex-grow">
                                                <div
                                                    class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                                    <div class="mb-2 sm:mb-0">
                                                        <h4 class="text-base md:text-lg font-bold text-gray-900">
                                                            {{ $product->title }}</h4>
                                                        <p class="text-xs md:text-sm text-gray-500 mt-1">
                                                            Event merchandise</p>
                                                    </div>
                                                    <div class="text-left sm:text-right">
                                                        <p class="text-lg md:text-xl font-bold text-primary-600">Rp
                                                            {{ number_format($product->price, 0, ',', '.') }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">{{ $product->quantity }}
                                                            available</p>
                                                    </div>
                                                </div>

                                                <div
                                                    class="mt-3 md:mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                                                    <div class="text-xs md:text-sm text-gray-600">
                                                        <i class="ri-shopping-bag-3-line mr-1 text-primary-500"></i> Event
                                                        Merchandise
                                                    </div>
                                                    <div
                                                        class="quantity-selector flex items-center justify-end sm:justify-start space-x-2">
                                                        <button type="button"
                                                            class="quantity-btn w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full transition-colors duration-200 quantity-decrease"
                                                            data-id="{{ $product->id }}">
                                                            <i class="fas fa-minus text-xs text-gray-600"></i>
                                                        </button>
                                                        <input type="number" id="quantity-{{ $product->id }}"
                                                            name="merchandise[{{ $product->id }}]" value="0"
                                                            min="0" max="{{ $product->quantity }}"
                                                            class="quantity-input w-10 md:w-12 text-center border border-gray-300 rounded-md py-1 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm md:text-base">
                                                        <button type="button"
                                                            class="quantity-btn w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full transition-colors duration-200 quantity-increase"
                                                            data-id="{{ $product->id }}">
                                                            <i class="fas fa-plus text-xs text-gray-600"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 md:py-10">
                                        <div class="text-gray-400 mb-3 md:mb-4">
                                            <i class="fas fa-tshirt text-3xl md:text-4xl"></i>
                                        </div>
                                        <p class="text-gray-500 text-sm md:text-base">No merchandise available at this
                                            time</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Order Summary Sticky Bar -->
                        <div class="col-span-2 sticky left-0 right-0 bottom-0 mt-20 bg-white border-t border-gray-200 shadow-lg rounded-t-xl p-6 transition-all duration-300 "
                            id="order-summary">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="mb-3 md:mb-0">
                                    <h4 class="text-base md:text-lg font-bold text-gray-900">Order Summary</h4>
                                    <p class="text-gray-600 text-xs md:text-sm" id="selected-items">0 items selected
                                    </p>
                                </div>
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                    <div class="text-base">
                                        <p class="text-gray-600 text-xs md:text-sm">Total</p>
                                        <p class="text-xl md:text-2xl font-bold text-primary-600" id="total-price">Rp
                                            0
                                        </p>
                                    </div>
                                    <button type="submit" form="order-form"
                                        class="checkout-btn px-4 py-2 sm:px-6 sm:py-2 md:px-8 md:py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105 transform flex items-center justify-center text-sm md:text-base">
                                        <span>Continue to Checkout</span>
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section class="relative bg-gray-50 py-16 md:py-24 overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Event Venue</h2>
                    <div class="w-20 h-1 bg-primary-500 mx-auto mb-4"></div>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Find your way to the event location with our interactive map
                    </p>
                </div>

                <div class="max-w-6xl mx-auto">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-xl">
                        @if ($event->location && $event->location->custom_maps_url)
                            <div class="aspect-w-16 aspect-h-9 w-full h-96 md:h-[500px]">
                                <iframe src="{{ $event->location->custom_maps_url }}" class="w-full h-full border-0"
                                    allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <div class="p-6 bg-white border-t border-gray-100">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $event->location->venue_name }}
                                        </h3>
                                        <address class="text-gray-600 not-italic mt-1">
                                            {{ $event->location->address_line }}<br>
                                            {{ $event->location->city }}, {{ $event->location->state }}
                                        </address>
                                    </div>
                                    <a href="{{ $event->location->custom_maps_url }}" target="_blank"
                                        class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-all duration-300">
                                        <i class="fas fa-directions mr-2"></i> Open in Maps
                                    </a>
                                </div>
                            </div>
                        @else
                            <div
                                class="aspect-w-16 aspect-h-9 w-full h-96 md:h-[500px] bg-gray-100 flex items-center justify-center">
                                <div class="text-center p-8">
                                    <i class="fas fa-map-marked-alt text-5xl text-primary-500 mb-4"></i>
                                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Location Not Specified</h3>
                                    <p class="text-gray-500 max-w-md mx-auto">This event doesn't have a physical
                                        location or the map hasn't been configured yet.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($event->location && $event->location->transportation_instructions)
                        <div class="mt-8 bg-white rounded-2xl shadow-md p-6 md:p-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-subway text-primary-500 mr-2"></i>
                                Transportation Guide
                            </h3>
                            <div class="prose max-w-none text-gray-600">
                                {!! $event->location->transportation_instructions !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <script>
        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Update order summary and hidden fields
            function updateOrderSummary() {
                let totalItems = 0;
                let totalPrice = 0;

                // Process all quantity inputs (both tickets and merchandise)
                document.querySelectorAll('input[type="number"].quantity-input').forEach(input => {
                    const quantity = parseInt(input.value) || 0;
                    const productId = input.id.split('-')[1]; // Get ID from input ID like "quantity-123"
                    const card = input.closest('.ticket-card, .product-card');
                    const isTicket = card.classList.contains('ticket-card');

                    // Update the corresponding hidden input
                    const hiddenInputName = isTicket ? `tickets[${productId}]` :
                        `merchandise[${productId}]`;
                    const hiddenInput = document.querySelector(
                        `input[type="hidden"][name="${hiddenInputName}"]`);

                    if (hiddenInput) {
                        hiddenInput.value = quantity;
                    }

                    // Calculate price if quantity > 0
                    if (quantity > 0) {
                        const priceText = card.querySelector('.text-primary-600').textContent;
                        const price = parseInt(priceText.replace(/[^\d]/g, ''));

                        totalItems += quantity;
                        totalPrice += quantity * price;
                    }
                });

                // Update summary display
                document.getElementById('selected-items').textContent =
                    `${totalItems} item${totalItems !== 1 ? 's' : ''} selected`;
                document.getElementById('total-price').textContent =
                    `Rp ${totalPrice.toLocaleString('id-ID')}`;

                // Toggle summary visibility
                const summary = document.getElementById('order-summary');
                if (totalItems > 0) {
                    summary.classList.add('show');
                } else {
                    summary.classList.remove('show');
                }
            }

            // Quantity button handlers
            function setupQuantityButtons() {
                // Increase quantity
                document.querySelectorAll('.quantity-increase').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.id;
                        const input = document.getElementById(`quantity-${productId}`);
                        if (input) {
                            const max = parseInt(input.max);
                            const newValue = Math.min(parseInt(input.value) + 1, max);
                            input.value = newValue;
                            updateOrderSummary();
                        }
                    });
                });

                // Decrease quantity
                document.querySelectorAll('.quantity-decrease').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.id;
                        const input = document.getElementById(`quantity-${productId}`);
                        if (input) {
                            const min = parseInt(input.min);
                            const newValue = Math.max(parseInt(input.value) - 1, min);
                            input.value = newValue;
                            updateOrderSummary();
                        }
                    });
                });

                // Manual input changes
                document.querySelectorAll('input[type="number"].quantity-input').forEach(input => {
                    input.addEventListener('change', function() {
                        const max = parseInt(this.max);
                        const min = parseInt(this.min);
                        let value = parseInt(this.value) || 0;

                        // Validate input
                        if (value > max) value = max;
                        if (value < min) value = min;

                        this.value = value;
                        updateOrderSummary();
                    });
                });
            }

            // Scroll handler for sticky summary
            function setupScrollHandler() {
                window.addEventListener('scroll', function() {
                    const ticketsSection = document.querySelector('#event-content');
                    const summary = document.getElementById('order-summary');
                    if (ticketsSection && summary) {
                        const hasItems = parseInt(document.getElementById('selected-items').textContent) >
                            0;
                        const shouldShow = window.scrollY > ticketsSection.offsetTop - 300 || hasItems;

                        if (shouldShow) {
                            summary.classList.add('show');
                        } else {
                            summary.classList.remove('show');
                        }
                    }
                });
            }

            // Initialize everything
            setupQuantityButtons();
            setupScrollHandler();
            updateOrderSummary();
        });
    </script>
</body>

</html>
