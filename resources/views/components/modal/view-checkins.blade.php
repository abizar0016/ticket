@foreach ($attendees as $attendee)
    <div id="checkinsViewModal-{{ $attendee->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                    id="checkinsViewBackdrop-{{ $attendee->id }}"></div>
            </div>

            <!-- Modal Panel -->
            <div id="checkinsViewPanel-{{ $attendee->id }}"
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full opacity-0 translate-y-4 sm:scale-95"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                <div class="bg-white px-6 pt-6 pb-4 sm:p-6">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow">
                                <i class="ri-user-line text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900" id="modal-headline">Attendee Details</h3>
                                <p class="text-indigo-600/80 text-lg mt-1">View attendee information</p>
                            </div>
                        </div>
                        <button id="closeViewCheckinsModal-{{ $attendee->id }}"
                            class="close-checkin-modal text-gray-400 hover:text-indigo-500 transition-colors duration-200 cursor-pointer"
                            data-id="{{ $attendee->id }}">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name and Email -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="relative">
                                <div
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border border-gray-300 bg-gray-50 text-gray-800">
                                    {{ $attendee->name }}
                                </div>
                                <label
                                    class="absolute left-14 top-4 px-2 text-gray-500 text-sm transform -translate-y-9 scale-90 bg-white rounded">
                                    Full Name
                                </label>
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500">
                                    <i class="ri-user-line text-2xl"></i>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="relative">
                                <div
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border border-gray-300 bg-gray-50 text-gray-800">
                                    {{ $attendee->email }}
                                </div>
                                <label
                                    class="absolute left-14 top-4 px-2 text-gray-500 text-sm transform -translate-y-9 scale-90 bg-white rounded">
                                    Email Address
                                </label>
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500">
                                    <i class="ri-mail-line text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Code and Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Ticket Code -->
                            <div class="relative">
                                <div
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border border-gray-300 bg-gray-50 text-gray-800">
                                    {{ $attendee->ticket_code }}
                                </div>
                                <label
                                    class="absolute left-14 top-4 px-2 text-gray-500 text-sm transform -translate-y-9 scale-90 bg-white rounded">
                                    Ticket Code
                                </label>
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500">
                                    <i class="ri-ticket-2-line text-2xl"></i>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="relative">
                                <div
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border border-gray-300 bg-gray-50 text-gray-800">
                                    @if ($attendee->status === 'used')
                                        <span
                                            class="text-sm font-semibold text-blue-700 bg-blue-100 px-2 py-1 rounded">Checked
                                            In</span>
                                    @elseif ($attendee->status === 'active')
                                        <span
                                            class="text-sm font-semibold text-green-700 bg-green-100 px-2 py-1 rounded">Active</span>
                                    @else
                                        <span
                                            class="text-sm font-semibold text-gray-700 bg-gray-200 px-2 py-1 rounded">Pending</span>
                                    @endif
                                </div>
                                <label
                                    class="absolute left-14 top-4 px-2 text-gray-500 text-sm transform -translate-y-9 scale-90 bg-white rounded">
                                    Status
                                </label>
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500">
                                    <i class="ri-flag-line text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Order Reference -->
                        <div class="relative">
                            <div
                                class="w-full px-5 py-4 pl-14 text-lg rounded-xl border border-gray-300 bg-gray-50 text-gray-800">
                                {{ $attendee->order->name }}
                            </div>
                            <label
                                class="absolute left-14 top-4 px-2 text-gray-500 text-sm transform -translate-y-9 scale-90 bg-white rounded">
                                Order Reference
                            </label>
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500">
                                <i class="ri-shopping-bag-line text-2xl"></i>
                            </div>
                        </div>

                        <!-- Check-in History -->
                        @if ($attendee->checkins && $attendee->checkins->count() > 0)
                            <div class="relative">
                                <div
                                    class="w-full px-5 py-4 text-lg rounded-xl border border-gray-300 bg-gray-50 text-gray-800">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="font-semibold text-gray-700">Check-in History</h4>
                                        <i class="ri-history-line text-2xl text-indigo-500"></i>
                                    </div>
                                    
                                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                        <div class="grid grid-cols-2 bg-gray-100 text-gray-600 text-sm font-medium px-4 py-2">
                                            <span>Date & Time</span>
                                            <span class="text-right">Checked By</span>
                                        </div>
                                        
                                        <div class="divide-y divide-gray-100 max-h-48 overflow-y-auto">
                                            @foreach ($attendee->checkins as $checkin)
                                                <div class="grid grid-cols-2 px-4 py-3 hover:bg-gray-50 transition-colors">
                                                    <div class="text-indigo-600 font-medium">
                                                        {{ \Carbon\Carbon::parse($checkin->checkin_time)->setTimezone($tz)->format('M j, Y') }}
                                                        <span class="text-indigo-400">
                                                            {{ \Carbon\Carbon::parse($checkin->checkin_time)->setTimezone($tz)->format('g:i A') }}
                                                        </span>
                                                    </div>
                                                    <div class="text-right text-sm text-gray-500">
                                                        {{ $checkin->checked_by ?? 'System' }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <label
                                    class="absolute left-5 top-4 px-2 text-gray-500 text-sm transform -translate-y-9 scale-90 bg-white rounded">
                                    Check-in History
                                </label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach