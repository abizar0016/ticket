@extends('layouts.app')

@section('content')
<div class="min-h-screen p-6">
    <!-- Animated Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Events -->
        <div
            class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium opacity-90">Total Events</p>
                    <h3 class="text-3xl font-bold mt-2 animate-count">{{ $eventsCount }}</h3>
                </div>
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                    <i class="ri-calendar-event-line text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Events -->
        <div
            class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite] delay-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium opacity-90">Active Events</p>
                    <h3 class="text-3xl font-bold mt-2 animate-count">{{ $ongoingCount }}</h3>
                </div>
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                    <i class="ri-flashlight-line text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div
            class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite] delay-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium opacity-90">Upcoming</p>
                    <h3 class="text-3xl font-bold mt-2 animate-count">{{ $upcomingCount }}</h3>
                </div>
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                    <i class="ri-time-line text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Ended Events -->
        <div
            class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite] delay-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium opacity-90">Ended Events</p>
                    <h3 class="text-3xl font-bold mt-2 animate-count">{{ $endedCount }}</h3>
                </div>
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                    <i class="ri-checkbox-circle-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 animate-[slideUp_0.8s_ease-out_forwards]">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="ri-calendar-event-line text-indigo-500"></i>
                Events Summary
            </h1>
            <p class="text-gray-500 mt-2">Manage your events and organization</p>
        </div>

        <!-- Create Button -->
        <div class="relative">
            <button id="openEventModal"
                class="inline-flex items-center gap-2 text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-xl text-sm px-5 py-3 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <i class="ri-add-line text-lg"></i>
                <span>Tambah</span>
            </button>
        </div>
    </div>

    <!-- Filter and Search Section -->
    @include('components.filters')

    <!-- Event Cards Grid -->
    @include('components.card.event')

    <!-- Pagination -->
    <div class="mt-8 animate-[fadeIn_0.8s_ease-out_forwards] delay-200">
        {{ $events->links('pagination::default') }}
    </div>
</div>

@include('modals.events.create')

@include('modals.organizations.create')
@endsection
