@extends('layouts.app')
@section('content')
    <div class="min-h-screen relative z-10 overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-20 -left-20 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30">
            </div>
            <div
                class="absolute bottom-1/2 -right-20 w-96 h-96 bg-indigo-800 rounded-full mix-blend-multiply filter blur-3xl opacity-30">
            </div>
            <div
                class="absolute bottom-20 left-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 ">
            </div>
        </div>

        <!-- Events Listing -->
        <section class="container m-auto py-16 sm:py-20 px-4 relative">
            <div class="mb-16">
                <div class="text-center mb-16">
                    <h1
                        class="text-4xl sm:text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-indigo-700 inline-block">
                        Explore Events
                    </h1>
                    <p class="text-gray-600 mt-4">
                        Discover upcoming and ongoing events in our vibrant community
                    </p>

                    <!-- Animated search bar -->
                    <div class="max-w-md mx-auto mt-8">
                        <form method="GET" action="{{ route('home') }}">
                            <div class="relative group">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search events..."
                                    class="w-full px-6 py-3 rounded-2xl border border-gray-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition-all duration-300 shadow-sm hover:shadow-md group-hover:shadow-lg bg-white/80 backdrop-blur-sm">
                                <button type="submit"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white p-2 rounded-xl hover:shadow-lg transform transition-all duration-300 hover:scale-110">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

                @if ($events->isEmpty())
                    <!-- Enhanced Empty State -->
                    <div
                        class="relative bg-white rounded-3xl shadow-xl p-12 text-center overflow-hidden border border-gray-100">
                        <div
                            class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,var(--tw-gradient-stops))] from-indigo-50/60 to-white/0">
                        </div>
                        <div class="relative z-10">
                            <div
                                class="mx-auto w-24 h-24 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                                <i class="fas fa-calendar-alt text-4xl text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No events found</h3>
                            <p class="text-gray-600/90 mb-8 max-w-md mx-auto text-lg">
                                We couldn't find any events matching your criteria
                            </p>
                            <a href="{{ route('home') }}"
                                class="inline-block px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-xl font-medium hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                Check back later
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($events as $index => $event)
                            @php
                                $eventStatus = 'Upcoming';
                                $statusColors = [
                                    'Ongoing' => 'bg-gradient-to-r from-emerald-400 to-emerald-600',
                                    'Upcoming' => 'bg-gradient-to-r from-blue-400 to-blue-600',
                                ];

                                if ($event->start_date > now()) {
                                    $eventStatus = 'Upcoming';
                                } else {
                                    $eventStatus = 'Ongoing';
                                }

                                // Calculate animation delay based on index
                                $animationDelay = min(($index % 6) * 100, 500);
                            @endphp

                            <div class="relative group transition-all duration-500 hover:z-10">
                                <div
                                    class="relative h-full transition-all duration-500 ease-out group-hover:-translate-y-2 group-hover:scale-[1.02]">
                                    <!-- Floating card effect -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-indigo-100/30 to-indigo-100/50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10 transform translate-y-4 group-hover:translate-y-0">
                                    </div>

                                    <div id="event-{{ $event->id }}"
                                        class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-500 h-full flex flex-col">
                                        <!-- Image Header with parallax effect -->
                                        <div class="relative h-52 overflow-hidden group">
                                            <div class="absolute inset-0 bg-gradient-to-b from-black/10 to-black/30 z-10">
                                            </div>
                                            <img src="{{ asset($event->event_image) ?? 'https://via.placeholder.com/800x500?text=Event+Image' }}"
                                                alt="{{ $event->title }}"
                                                class="w-full h-full object-cover transition-transform duration-1000 ease-out group-hover:scale-110">

                                            <!-- Floating date badge -->
                                            <div
                                                class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2 shadow-lg border border-white/20 z-20 transform transition-all duration-500 group-hover:-translate-y-1 group-hover:shadow-md">
                                                <div class="text-sm font-bold text-gray-900">
                                                    {{ $event->start_date->translatedFormat('M j') }}
                                                    @if ($event->end_date && !$event->start_date->isSameDay($event->end_date))
                                                        <span class="font-normal">-
                                                            {{ $event->end_date->translatedFormat('M j, Y') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Floating status badge -->
                                            <div
                                                class="absolute top-4 right-4 flex items-center gap-2 transform transition-all duration-500 group-hover:scale-110">
                                                <span
                                                    class="{{ $statusColors[$eventStatus] }} text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md backdrop-blur-sm flex items-center gap-1">
                                                    <i class="ri-time-line"></i>
                                                    {{ $eventStatus }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Event Content -->
                                        <div class="p-6 flex-1 flex flex-col">
                                            <h2
                                                class="text-xl font-extrabold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors duration-300 line-clamp-2">
                                                {{ $event->title }}
                                            </h2>

                                            <div class="space-y-3 mb-4 text-sm text-gray-700">
                                                <div
                                                    class="flex items-center transition-all duration-300 hover:text-indigo-600">
                                                    <i class="fas fa-clock text-indigo-500 mr-2 w-4 text-center"></i>
                                                    <span>{{ $event->start_date->format('g:i A') }} -
                                                        {{ $event->end_date->format('g:i A') }} (Asia/Jakarta)</span>
                                                </div>
                                                @if ($event->vanue_name || $event->address_line || $event->city)
                                                    <div
                                                        class="flex items-center transition-all duration-300 hover:text-indigo-600">
                                                        <i
                                                            class="fas fa-map-marker-alt text-indigo-500 mr-2 w-4 text-center"></i>
                                                        <span>{{ $event->venue_name }}</span>
                                                        <span class="text-gray-600">,
                                                            {{ $event->address_line }}</span>
                                                        <span>, {{ $event->city }}</span>
                                                    </div>
                                                @else
                                                    <div
                                                        class="flex items-center transition-all duration-300 hover:text-indigo-600">
                                                        <i
                                                            class="fas fa-map-marker-alt text-indigo-500 mr-2 w-4 text-center"></i>
                                                        <span>Online Event</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <p class="text-gray-600 mb-5 text-sm leading-relaxed line-clamp-3">
                                                {{ Str::limit(strip_tags($event->description), 150) }}
                                            </p>

                                            <div class="mt-auto">
                                                <a href="{{ route('events.show', $event->id) }}"
                                                    class="view-tickets-btn bg-gradient-to-r from-indigo-500 to-indigo-600 text-white py-3 px-6 rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 font-medium flex items-center justify-center w-full group relative overflow-hidden">
                                                    <span
                                                        class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                                    <span class="relative z-10 flex items-center justify-center">
                                                        <span
                                                            class="group-hover:translate-x-1 transition-transform duration-300">View
                                                            Events</span>
                                                        <i
                                                            class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

    </div>

    <!-- Scripts -->
    @if (session()->has('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: "warning",
                    title: "Oops!",
                    position: "top",
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    backdrop: true,
                    background: "#ffffff",
                    text: @json(session('error')),
                });
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            localStorage.removeItem("shoppingCart");

            Swal.fire({
                title: 'Sukses!',
                text: '{{ session('success') }}',
                icon: 'success',
                toast: true,
                position: 'bottom-start',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#ffffff',
                backdrop: true
            });
        </script>
    @endif

@endsection
