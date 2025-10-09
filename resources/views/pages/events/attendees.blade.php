<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-3 sm:p-4 md:p-6 transition-colors duration-500">
    <!-- Dynamic Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-5 md:gap-6">
        <!-- Animated Header -->
        <div
            class="lg:col-span-12 relative overflow-hidden rounded-lg sm:rounded-xl md:rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-gray-700 dark:to-gray-800 p-4 sm:p-6 md:p-8 mb-4 sm:mb-5 md:mb-6 shadow-md sm:shadow-lg md:shadow-xl transition-all duration-500 hover:shadow-lg sm:hover:shadow-xl md:hover:shadow-2xl group">
            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 md:gap-6">
                <div
                    class="p-2 sm:p-3 md:p-4 rounded-md sm:rounded-lg md:rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-sm md:shadow-md">
                    <i class="ri-group-line text-xl sm:text-2xl md:text-3xl"></i>
                </div>
                <div>
                    <h1
                        class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                        Event Attendees
                    </h1>
                    <p class="text-indigo-600/80 dark:text-indigo-400/80 text-sm sm:text-base md:text-lg mt-1 sm:mt-2">
                        Manage your event participants</p>
                </div>
            </div>
            <div
                class="absolute right-3 sm:right-6 md:right-10 top-0 text-black/10 dark:text-white/5 text-5xl sm:text-7xl md:text-9xl z-0">
                <i class="ri-group-line"></i>
            </div>
        </div>

        <!-- Main Content (8/12 width) -->
        <div class="lg:col-span-8">
            <!-- Search and Filter Bar -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl md:rounded-2xl p-3 sm:p-4 md:p-6 mb-4 sm:mb-5 md:mb-6 shadow-md sm:shadow-lg md:shadow-xl border border-gray-100 dark:border-gray-700 transition-colors duration-500">
                <form
                    action="{{ route(Auth::user()->role == 'superadmin' ? 'superAdmin.events.attendees' : 'admin.events.attendees', $eventId) }}"
                    method="GET"
                    class="flex flex-col sm:flex-row gap-2 sm:gap-3 md:gap-4 items-stretch sm:items-center">
                    <div class="relative w-full group">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 dark:text-gray-500 group-focus-within:text-indigo-500 transition-colors">
                            <i class="ri-search-line text-sm sm:text-base"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search attendees..."
                            class="bg-white dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100 text-xs sm:text-sm md:text-base rounded-lg sm:rounded-xl focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none block w-full pl-9 sm:pl-10 p-2 sm:p-2.5 transition-all duration-300 group-hover:shadow-sm sm:group-hover:shadow-md">
                    </div>

                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit"
                            class="px-3 sm:px-4 py-2 w-full sm:w-auto border-2 border-transparent rounded-lg sm:rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-xs sm:text-sm font-medium text-white hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 flex items-center justify-center gap-1 sm:gap-2">
                            <i class="ri-search-line text-sm sm:text-base"></i>Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Attendees Table -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl md:rounded-2xl shadow-md sm:shadow-lg md:shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors duration-500">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px]">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Attendee
                                </th>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell">
                                    Contact
                                </th>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Ticket
                                </th>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 text-right text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($attendees as $attendee)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <div
                                                class="flex-shrink-0 h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 flex items-center justify-center text-white font-medium sm:font-bold text-xs sm:text-sm">
                                                {{ substr($attendee->name, 0, 1) }}{{ substr(strstr($attendee->name, ' '), 1, 1) ?? '' }}
                                            </div>
                                            <div>
                                                <div
                                                    class="font-medium text-gray-900 dark:text-gray-100 text-xs sm:text-sm md:text-base">
                                                    {{ $attendee->name }}</div>
                                                <div class="text-gray-500 dark:text-gray-400 text-2xs sm:text-xs">
                                                    {{ $attendee->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap flex flex-col">
                                        <a href="https://mail.google.com/mail/?view=cm&to={{ $attendee->email }}"
                                            target="_blank"
                                            class="text-gray-900 dark:text-gray-100 text-xs sm:text-sm md:text-base hover:underline">
                                            {{ $attendee->email }}
                                        </a>
                                        <a href="https://wa.me/{{ $attendee->phone }}" target="_blank"
                                            class="text-gray-800 dark:text-gray-300 text-xs sm:text-sm md:text-base hover:underline">
                                            {{ $attendee->phone }}
                                        </a>

                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap">
                                        <div
                                            class="text-gray-900 dark:text-gray-100 font-mono text-xs sm:text-sm md:text-base">
                                            {{ $attendee->ticket_code ?? 'N/A' }}</div>
                                        <div class="text-gray-500 dark:text-gray-400 text-2xs sm:text-xs">Order
                                            {{ $attendee->order->name }}</div>
                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap">
                                        @if ($attendee->status === 'active')
                                            <span
                                                class="px-1.5 sm:px-2 py-0.5 sm:py-1 text-2xs sm:text-xs rounded-full bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 font-medium flex items-center gap-1 w-fit">
                                                <i class="ri-checkbox-circle-line text-xs sm:text-sm"></i> <span
                                                    class="hidden sm:inline">Active</span>
                                            </span>
                                        @elseif ($attendee->status === 'used')
                                            <span
                                                class="px-1.5 sm:px-2 py-0.5 sm:py-1 text-2xs sm:text-xs rounded-full bg-blue-100 dark:bg-blue-900/40 text-indigo-800 dark:text-indigo-300 font-medium flex items-center gap-1 w-fit">
                                                <i class="ri-checkbox-circle-line text-xs sm:text-sm"></i> <span
                                                    class="hidden sm:inline">Used</span>
                                            </span>
                                        @else
                                            <span
                                                class="px-1.5 sm:px-2 py-0.5 sm:py-1 text-2xs sm:text-xs rounded-full bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300 font-medium flex items-center gap-1 w-fit">
                                                <i class="ri-time-line text-xs sm:text-sm"></i> <span
                                                    class="hidden sm:inline">Pending</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-right">
                                        <div class="flex justify-end items-center gap-1 sm:gap-2">
                                            <button id="open-attendees-update-modal-{{ $attendee->id }}"
                                                class="p-1 sm:p-1.5 md:p-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition"
                                                title="Edit" data-id="{{ $attendee->id }}">
                                                <i class="ri-edit-line text-base sm:text-lg md:text-xl"></i>
                                            </button>

                                            <form id="delete-attendee-{{ $attendee->id }}" class="ajax-form"
                                                action="{{ route('attendees.destroy', $attendee->id) }}" method="POST"
                                                data-success="Attendee deleted successfully"
                                                data-confirm="Are you sure you want to delete this attendee?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1 sm:p-1.5 md:p-2 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition cursor-pointer"
                                                    title="Delete">
                                                    <i class="ri-delete-bin-line text-base sm:text-lg md:text-xl"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 sm:px-6 py-6 text-center">
                                        <div
                                            class="flex flex-col items-center justify-center gap-2 sm:gap-3 text-gray-400 dark:text-gray-500">
                                            <i class="ri-user-search-line text-2xl sm:text-3xl md:text-4xl"></i>
                                            <p class="text-sm sm:text-base md:text-lg">No attendees found</p>
                                            <p class="text-2xs sm:text-xs md:text-sm">Try adjusting your search or
                                                filters</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $attendees->appends(['content' => 'attendees'])->links() }}
                </div>
            </div>

        </div>

        <!-- Right Sidebar (4/12 width) -->
        <div class="lg:col-span-4">
            <div class="sticky top-16 sm:top-20 space-y-4 sm:space-y-5 md:space-y-6">
                <!-- Summary Card -->
                <div
                    class="bg-white dark:bg-gray-800 h-full rounded-lg sm:rounded-xl md:rounded-2xl p-3 sm:p-4 md:p-6 shadow-md sm:shadow-lg md:shadow-xl border border-purple-100 dark:border-gray-700 transition-all duration-500 hover:shadow-sm sm:hover:shadow-md md:hover:shadow-lg hover:-translate-y-0.5 sm:hover:-translate-y-1">
                    <h3
                        class="text-base sm:text-lg md:text-xl font-bold text-gray-800 dark:text-gray-100 mb-2 sm:mb-3 md:mb-4 flex items-center gap-1 sm:gap-2">
                        <i
                            class="ri-line-chart-line text-indigo-500 dark:text-indigo-400 text-lg sm:text-xl md:text-2xl"></i>
                        Attendance Summary
                    </h3>

                    <div class="space-y-2 sm:space-y-3 md:space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Total
                                    Registered</span>
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-bold text-gray-900 dark:text-gray-100">{{ $totalAttendees }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Used</span>
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-bold text-gray-900 dark:text-gray-100">{{ $usedAttendees }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 sm:h-2">
                                <div class="bg-indigo-600 h-1.5 sm:h-2 rounded-full"
                                    style="width: {{ $usedPercentage }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-bold text-gray-900 dark:text-gray-100">{{ $activeAttendees }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 sm:h-2">
                                <div class="bg-green-500 h-1.5 sm:h-2 rounded-full"
                                    style="width: {{ $activePercentage }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Pending</span>
                                <span
                                    class="text-2xs sm:text-xs md:text-sm font-bold text-gray-900 dark:text-gray-100">{{ $pendingAttendees }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 sm:h-2">
                                <div class="bg-yellow-500 h-1.5 sm:h-2 rounded-full"
                                    style="width: {{ $pendingPercentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.attendees.update')
