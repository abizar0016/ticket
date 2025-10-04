@extends('layouts.app')

@section('content')
    <section class="event-show-page overflow-hidden dark:bg-gray-900 transition-colors duration-300">
        <!-- Hero Section with Parallax Effect -->
        <div class="event-hero w-full h-screen bg-cover bg-center relative overflow-hidden group"
            style="background-image: url('{{ asset($event->event_image) }}')">
            <!-- Animated Gradient Overlay -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/20 z-0 opacity-100 group-hover:opacity-90 transition-all duration-1000">
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
                            class="meta-item flex items-center text-white/90 group-hover:text-white transition-all duration-300 hover:scale-105">
                            <div
                                class="icon-container w-10 h-10 bg-primary-500/20 rounded-full flex items-center justify-center mr-3 group-hover:bg-primary-500/30 transition-all duration-300 group-hover:rotate-12">
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
                            class="meta-item flex items-center text-white/90 group-hover:text-white transition-all duration-300 hover:scale-105">
                            <div
                                class="icon-container w-10 h-10 bg-primary-500/20 rounded-full flex items-center justify-center mr-3 group-hover:bg-primary-500/30 transition-all duration-300 group-hover:rotate-12">
                                <i
                                    class="fas fa-map-marker-alt text-primary-300 group-hover:text-primary-200 transition-colors duration-300"></i>
                            </div>
                            @php
                                $locationParts = collect([
                                    $event->venue_name,
                                    $event->address_line,
                                    $event->city,
                                    $event->state,
                                ])
                                    ->filter()
                                    ->implode(', ');
                            @endphp

                            <span class="font-medium tracking-wide">
                                {{ $locationParts ?? 'Online Event' }}
                            </span>
                        </div>
                        @if ($event->start_time)
                            <div
                                class="meta-item flex items-center text-white/90 group-hover:text-white transition-all duration-300 hover:scale-105">
                                <div
                                    class="icon-container w-10 h-10 bg-primary-500/20 rounded-full flex items-center justify-center mr-3 group-hover:bg-primary-500/30 transition-all duration-300 group-hover:rotate-12">
                                    <i
                                        class="fas fa-clock text-primary-300 group-hover:text-primary-200 transition-colors duration-300"></i>
                                </div>
                                <span class="font-medium tracking-wide">
                                    {{ $event->start_time->format('g:i A') }}
                                    @if ($event->end_time)
                                        - {{ $event->end_time->format('g:i A') }}
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                        <a href="#tickets"
                            class="px-8 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-bold rounded-lg border border-white/20 transition-all duration-300 transform hover:scale-105 flex items-center justify-center cursor-pointer">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Get Tickets
                        </a>
                        <a href="#event-content"
                            class="px-8 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-bold rounded-lg border border-white/20 transition-all duration-300 transform hover:scale-105 flex items-center justify-center cursor-pointer">
                            <i class="fas fa-info-circle mr-2"></i>
                            Learn More
                        </a>

                        <button type="button"
                            onclick="navigator.share ? navigator.share({ title: '{{ $event->title }}', url: '{{ route('events.show', $event->id) }}' }) : copyToClipboard('{{ route('events.show', $event->id) }}')"
                            class="px-8 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-bold rounded-lg border border-white/20 transition-all duration-300 transform hover:scale-105 flex items-center justify-center cursor-pointer">
                            <i class="ri-share-forward-line mr-2"></i>
                            Share
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Event Content Section -->
        <div id="event-content"
            class="relative bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 py-24 overflow-hidden transition-colors duration-300">

            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <h2
                        class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-800 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                        About {{ $event->title }}
                    </h2>
                    <p class="text-xl leading-relaxed text-gray-700 dark:text-gray-300">
                        {{ $event->description ?? 'Event description will appear here...' }}
                    </p>
                </div>

                <!-- Additional Event Details -->
                @if ($event->additional_info)
                    <div
                        class="max-w-4xl mx-auto mt-16 bg-white dark:bg-gray-700/50 rounded-2xl p-8 shadow-lg border border-gray-200 dark:border-gray-600 backdrop-blur-sm">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-info-circle text-primary-500 mr-3"></i>
                            Event Details
                        </h3>
                        <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                            {!! $event->additional_info !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tickets & Products Section -->
        <div id="tickets"
            class="relative bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 py-24 overflow-hidden transition-colors duration-300">
        </div>

        <div class="container mx-auto px-4 sm:px-6 relative z-10">
            <div class="text-center mb-8 md:mb-16">
                <h2
                    class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-3 md:mb-4 bg-gradient-to-r from-gray-800 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text">
                    Tickets & Merchandise
                </h2>
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
                    Choose from our selection of tickets and exclusive event merchandise
                </p>
            </div>

            <div class="max-w-6xl mx-auto">
                <form action="{{ route('checkouts') }}" method="POST" id="order-form"
                    class="flex flex-col lg:grid lg:grid-cols-2 gap-6 md:gap-8">
                    @csrf
                    <!-- Tickets Column -->
                    <div class="tickets-column">
                        <div class="flex items-center mb-4 md:mb-6">
                            <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                <span
                                    class="w-6 h-6 md:w-8 md:h-8 bg-primary-500 rounded-full flex items-center justify-center text-white mr-2 md:mr-3 text-sm md:text-base">1</span>
                                Select Tickets
                            </h3>
                            <div
                                class="ml-auto px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full text-xs md:text-sm font-medium">
                                Required
                            </div>
                        </div>

                        <div class="space-y-3 md:space-y-4">
                            @forelse ($event->products->where('type', 'ticket') as $ticket)
                                <input type="hidden" name="tickets[{{ $ticket->id }}]" value="0">

                                <div
                                    class="ticket-card group relative bg-white dark:bg-gray-700 rounded-lg md:rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-600 hover:border-primary-300 dark:hover:border-primary-500 transition-all duration-300 overflow-hidden">

                                    <!-- Hover effect background -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-primary-50 to-transparent dark:from-primary-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-lg md:rounded-xl">
                                    </div>

                                    <div class="relative z-10 p-4 md:p-6 flex flex-col">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                            <div>
                                                <h4 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">
                                                    {{ $ticket->title }}
                                                </h4>
                                                <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    Scan mode: <span
                                                        class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst($ticket->scan_mode ?? 'single') }}</span>
                                                </p>
                                                <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                    Sale period:
                                                    {{ $ticket->sale_start_date?->format('M d, Y') }}
                                                    -
                                                    {{ $ticket->sale_end_date?->format('M d, Y') ?? 'No limit' }}
                                                </p>
                                            </div>
                                            <div class="text-left sm:text-right mt-3 sm:mt-0">
                                                <p
                                                    class="text-lg md:text-xl font-bold text-primary-600 dark:text-primary-400">
                                                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    @if ($ticket->quantity === null)
                                                        <span
                                                            class="font-semibold text-green-600 dark:text-green-400">Unlimited</span>
                                                    @elseif ($ticket->quantity <= 0)
                                                        <span class="font-semibold text-red-600 dark:text-red-400">Sold
                                                            Out</span>
                                                    @else
                                                        <span
                                                            class="font-medium text-gray-700 dark:text-gray-300">{{ $ticket->quantity . ' available' }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Quantity selector -->
                                        <div
                                            class="mt-3 md:mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                                            <div class="text-xs md:text-sm text-gray-600 dark:text-gray-400">
                                                <i class="ri-ticket-2-line mr-1 text-primary-500"></i> Ticket
                                            </div>
                                            <div class="quantity-selector flex items-center space-x-2">
                                                <button type="button"
                                                    class="quantity-btn w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 rounded-full transition-colors duration-200 quantity-decrease"
                                                    data-id="{{ $ticket->id }}">
                                                    <i class="fas fa-minus text-xs text-gray-600 dark:text-gray-300"></i>
                                                </button>
                                                <input type="number" id="quantity-{{ $ticket->id }}"
                                                    name="tickets[{{ $ticket->id }}]" value="0" min="0"
                                                    max="{{ $ticket->quantity }}"
                                                    class="quantity-input w-10 md:w-12 text-center border border-gray-300 dark:border-gray-600 rounded-md py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm md:text-base">
                                                <button type="button"
                                                    class="quantity-btn w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 rounded-full transition-colors duration-200 quantity-increase"
                                                    data-id="{{ $ticket->id }}">
                                                    <i class="fas fa-plus text-xs text-gray-600 dark:text-gray-300"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="text-center py-6 md:py-10 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                                    <div class="text-gray-400 dark:text-gray-500 mb-3 md:mb-4">
                                        <i class="fas fa-ticket-alt text-3xl md:text-4xl"></i>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm md:text-base">No tickets
                                        available at this time</p>
                                </div>
                            @endforelse

                        </div>
                    </div>

                    <!-- Merchandise Column -->
                    <div class="merchandise-column mt-6 md:mt-0">
                        <div class="flex items-center mb-4 md:mb-6">
                            <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                <span
                                    class="w-6 h-6 md:w-8 md:h-8 bg-primary-500 rounded-full flex items-center justify-center text-white mr-2 md:mr-3 text-sm md:text-base">2</span>
                                Add Merchandise
                            </h3>
                            <div
                                class="ml-auto px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full text-xs md:text-sm font-medium">
                                Optional
                            </div>
                        </div>

                        <div class="space-y-3 md:space-y-4">
                            @forelse ($event->products->where('type', '!=', 'ticket') as $product)
                                <input type="hidden" name="merchandise[{{ $product->id }}]" value="0">

                                <div
                                    class="product-card group relative bg-white dark:bg-gray-700 rounded-lg md:rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-600 hover:border-primary-300 dark:hover:border-primary-500 transition-all duration-300 overflow-hidden mb-4">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-white to-primary-50 dark:from-gray-700 dark:to-primary-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-lg md:rounded-xl">
                                    </div>
                                    <div class="relative z-10 p-4 md:p-6 flex flex-col sm:flex-row">
                                        {{-- Product Image --}}
                                        <div class="flex-shrink-0 mb-3 sm:mb-0 sm:mr-4 md:mr-5">
                                            <img src="{{ $product->image ? asset($product->image) : asset('images/placeholder.png') }}"
                                                alt="{{ $product->title }}"
                                                class="w-full sm:w-20 md:w-24 h-auto sm:h-20 md:h-24 object-cover rounded-lg shadow-inner mx-auto sm:mx-0">
                                        </div>

                                        {{-- Product Info --}}
                                        <div class="flex-grow">
                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                                <div class="mb-2 sm:mb-0">
                                                    <h4
                                                        class="text-base md:text-lg font-bold text-gray-900 dark:text-white">
                                                        {{ $product->title }}
                                                    </h4>
                                                    <p
                                                        class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                                        {{ $product->description ?? 'Event merchandise' }}
                                                    </p>
                                                </div>
                                                <div class="text-left sm:text-right">
                                                    <p
                                                        class="text-lg md:text-xl font-bold text-primary-600 dark:text-primary-400">
                                                        Rp
                                                        {{ number_format($product->price, 0, ',', '.') }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        @if ($product->quantity === null)
                                                            <span
                                                                class="font-semibold text-green-600 dark:text-green-400">Unlimited</span>
                                                        @else
                                                            <span
                                                                class="font-medium text-gray-700 dark:text-gray-300">{{ $product->quantity . ' available' }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Quantity Selector --}}
                                            <div
                                                class="mt-3 md:mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                                                <div class="text-xs md:text-sm text-gray-600 dark:text-gray-400">
                                                    <i class="ri-shopping-bag-3-line mr-1 text-primary-500"></i>
                                                    Event Merchandise
                                                </div>
                                                <div
                                                    class="quantity-selector flex items-center justify-end sm:justify-start space-x-2">
                                                    <button type="button"
                                                        class="quantity-btn w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 rounded-full transition-colors duration-200 quantity-decrease"
                                                        data-id="{{ $product->id }}">
                                                        <i
                                                            class="fas fa-minus text-xs text-gray-600 dark:text-gray-300"></i>
                                                    </button>
                                                    <input type="number" id="quantity-{{ $product->id }}"
                                                        name="merchandise[{{ $product->id }}]" value="0"
                                                        min="0" max="{{ $product->quantity }}"
                                                        class="quantity-input w-10 md:w-12 text-center border border-gray-300 dark:border-gray-600 rounded-md py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm md:text-base">
                                                    <button type="button"
                                                        class="quantity-btn w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 rounded-full transition-colors duration-200 quantity-increase"
                                                        data-id="{{ $product->id }}">
                                                        <i
                                                            class="fas fa-plus text-xs text-gray-600 dark:text-gray-300"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="text-center py-6 md:py-10 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                                    <div class="text-gray-400 dark:text-gray-500 mb-3 md:mb-4">
                                        <i class="fas fa-tshirt text-3xl md:text-4xl"></i>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm md:text-base">No merchandise
                                        available at this time
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Order Summary Sticky Bar -->
                    <div class="col-span-2 sticky left-0 right-0 bottom-0 mt-20 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg rounded-t-xl p-6 transition-all duration-300 transform"
                        id="order-summary">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="mb-3 md:mb-0">
                                <h4 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Order Summary
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400 text-xs md:text-sm" id="selected-items">0
                                    items selected
                                </p>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <div class="text-base">
                                    <p class="text-gray-600 dark:text-gray-400 text-xs md:text-sm">Total</p>
                                    <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white"
                                        id="total-price">Rp
                                        0
                                    </p>
                                </div>
                                <button type="submit" form="order-form"
                                    class="checkout-btn px-4 py-2 sm:px-6 sm:py-2 md:px-8 md:py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 dark:from-indigo-600 dark:to-indigo-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105 transform flex items-center justify-center text-sm md:text-base disabled:opacity-50 disabled:cursor-not-allowed"
                                    id="checkout-button" disabled>
                                    <span>Continue to Checkout</span>
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>

        <!-- Map Section -->
        <div class="relative bg-gray-50 dark:bg-gray-900 py-16 md:py-24 overflow-hidden transition-colors duration-300">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">Event Venue</h2>
                    <div class="w-20 h-1 bg-primary-500 mx-auto mb-4"></div>
                    <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Find your way to the event location with our interactive map
                    </p>
                </div>

                <div class="max-w-6xl mx-auto">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-xl">
                        @if ($event->custom_maps_url)
                            <div class="aspect-w-16 aspect-h-9 w-full h-96 md:h-[500px]">
                                <iframe src="{{ $event->custom_maps_url }}" class="w-full h-full border-0"
                                    allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <div class="p-6 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                            {{ $event->venue_name }}
                                        </h3>
                                        <address class="text-gray-600 dark:text-gray-400 not-italic mt-1">
                                            {{ $event->address_line }}<br>
                                            {{ $event->city }}, {{ $event->state }}
                                        </address>
                                    </div>
                                    <a href="{{ $event->custom_maps_url }}" target="_blank"
                                        class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-directions mr-2"></i> Open in Maps
                                    </a>
                                </div>
                            </div>
                        @else
                            <div
                                class="aspect-w-16 aspect-h-9 w-full h-96 md:h-[500px] bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                <div class="text-center p-8">
                                    <i class="fas fa-map-marked-alt text-5xl text-primary-500 mb-4"></i>
                                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Location Not
                                        Specified</h3>
                                    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">This event doesn't have a
                                        physical
                                        location or the map hasn't been configured yet.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($event->location && $event->transportation_instructions)
                        <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 md:p-8">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-subway text-primary-500 mr-2"></i>
                                Transportation Guide
                            </h3>
                            <div class="prose max-w-none text-gray-600 dark:text-gray-400 dark:prose-invert">
                                {!! $event->transportation_instructions !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===============================
            // UPDATE ORDER SUMMARY
            // ===============================
            function updateOrderSummary() {
                let totalItems = 0;
                let totalPrice = 0;

                document.querySelectorAll('input[type="number"].quantity-input').forEach(input => {
                    let quantity = parseInt(input.value) || 0;
                    const productId = input.id.split('-')[1];
                    const card = input.closest('.ticket-card, .product-card');
                    const isTicket = card.classList.contains('ticket-card');

                    // Update hidden input
                    const hiddenInputName = isTicket ? `tickets[${productId}]` :
                        `merchandise[${productId}]`;
                    const hiddenInput = document.querySelector(
                        `input[type="hidden"][name="${hiddenInputName}"]`);
                    if (hiddenInput) hiddenInput.value = quantity;

                    // Calculate price
                    if (quantity > 0) {
                        const priceText = card.querySelector('.text-primary-600, .text-primary-400')
                            .textContent;
                        const price = parseInt(priceText.replace(/[^\d]/g, '')) || 0;
                        totalItems += quantity;
                        totalPrice += quantity * price;
                    }
                });

                document.getElementById('selected-items').textContent =
                    `${totalItems} item${totalItems !== 1 ? 's' : ''} selected`;
                document.getElementById('total-price').textContent =
                    `Rp ${totalPrice.toLocaleString('id-ID')}`;

                // Toggle summary visibility and checkout button state
                const summary = document.getElementById('order-summary');
                const checkoutButton = document.getElementById('checkout-button');

                if (totalItems > 0) {
                    checkoutButton.disabled = false;
                } else {
                    ;
                    checkoutButton.disabled = true;
                }
            }

            // ===============================
            // QUANTITY BUTTONS
            // ===============================
            function setupQuantityButtons() {
                document.querySelectorAll('.quantity-increase').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.id;
                        const input = document.getElementById(`quantity-${productId}`);
                        if (!input) return;

                        let currentValue = parseInt(input.value) || 0;
                        const max = parseInt(input.max);

                        if (isNaN(max)) {
                            // Unlimited
                            input.value = currentValue + 1;
                        } else {
                            input.value = Math.min(currentValue + 1, max);
                        }

                        updateOrderSummary();
                    });
                });

                document.querySelectorAll('.quantity-decrease').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.id;
                        const input = document.getElementById(`quantity-${productId}`);
                        if (!input) return;

                        let currentValue = parseInt(input.value) || 0;
                        const min = parseInt(input.min) || 0;
                        input.value = Math.max(currentValue - 1, min);

                        updateOrderSummary();
                    });
                });

                // Manual input change
                document.querySelectorAll('input[type="number"].quantity-input').forEach(input => {
                    input.addEventListener('change', function() {
                        let value = parseInt(this.value) || 0;
                        const min = parseInt(this.min) || 0;
                        const max = parseInt(this.max);

                        if (value < min) value = min;
                        if (!isNaN(max) && value > max) value = max;

                        this.value = value;
                        updateOrderSummary();
                    });
                });
            }


            // ===============================
            // INITIALIZE
            // ===============================
            setupQuantityButtons();
            updateOrderSummary();
        });
    </script>
@endsection
