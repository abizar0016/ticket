@foreach ($attendees as $attendee)
    <div id="checkinsViewModal-{{ $attendee->id }}"
        class="fixed flex justify-center items-center inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center sm:block sm:p-0">
            {{-- Backdrop --}}
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div id="checkinsViewBackdrop-{{ $attendee->id }}"
                    class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300">
                </div>
            </div>

            {{-- Modal Panel --}}
            <div id="checkinsViewPanel-{{ $attendee->id }}"
                class="rounded-2xl overflow-hidden shadow-xl transform transition-all sm:max-w-2xl w-full opacity-0 translate-y-4 scale-95"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                <div class="bg-white dark:bg-gray-800 px-8 pt-8 pb-6 sm:p-8 sm:pb-6 max-h-[90vh] overflow-y-auto">
                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
                                <i class="ri-user-line text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100" id="modal-headline">
                                    Attendee Details
                                </h3>
                                <p class="text-indigo-600 dark:text-indigo-400 text-lg mt-1">
                                    View attendee information
                                </p>
                            </div>
                        </div>
                        <button id="closeViewCheckinsModal"
                            class="text-gray-400 hover:text-indigo-500 transition-colors duration-200 cursor-pointer"
                            data-id="{{ $attendee->id }}">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    {{-- Content --}}
                    <div class="grid grid-cols-1 gap-6">
                        {{-- Name and Email --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name --}}
                            <div class="relative group">
                                <div
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 shadow-sm">
                                    {{ $attendee->name }}
                                </div>
                                <label
                                    class="absolute left-14 top-4 px-2 text-gray-500 dark:text-gray-400 text-sm transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded">
                                    Full Name
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-user-line text-2xl"></i>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="relative group">
                                <div
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 shadow-sm">
                                    {{ $attendee->email }}
                                </div>
                                <label
                                    class="absolute left-14 top-4 px-2 text-gray-500 dark:text-gray-400 text-sm transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded">
                                    Email Address
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-mail-line text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Ticket Code and Status --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Ticket Code --}}
                            <div class="relative group">
                                <div
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 shadow-sm">
                                    {{ $attendee->ticket_code }}
                                </div>
                                <label
                                    class="absolute left-14 top-4 px-2 text-gray-500 dark:text-gray-400 text-sm transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded">
                                    Ticket Code
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-ticket-2-line text-2xl"></i>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="relative group">
                                <div
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 shadow-sm">
                                    @if ($attendee->status === 'used')
                                        <span
                                            class="text-sm font-semibold text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-700/30 px-2 py-1 rounded">
                                            Checked In
                                        </span>
                                    @elseif ($attendee->status === 'active')
                                        <span
                                            class="text-sm font-semibold text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-700/30 px-2 py-1 rounded">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/40 px-2 py-1 rounded">
                                            Pending
                                        </span>
                                    @endif
                                </div>
                                <label
                                    class="absolute left-14 top-4 px-2 text-gray-500 dark:text-gray-400 text-sm transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded">
                                    Status
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-flag-line text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Order Reference --}}
                        <div class="relative group">
                            <div
                                class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 shadow-sm">
                                {{ $attendee->order->name }}
                            </div>
                            <label
                                class="absolute left-14 top-4 px-2 text-gray-500 dark:text-gray-400 text-sm transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded">
                                Order Reference
                            </label>
                            <div
                                class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                                <i class="ri-shopping-bag-line text-2xl"></i>
                            </div>
                        </div>

                        {{-- Check-in History --}}
                        @if ($attendee->checkins && $attendee->checkins->count() > 0)
                            <div class="relative group">
                                <div
                                    class="w-full px-5 py-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100 shadow-sm">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="font-semibold text-gray-700 dark:text-gray-200">
                                            Check-in History
                                        </h4>
                                        <i class="ri-history-line text-2xl text-indigo-500 dark:text-indigo-400"></i>
                                    </div>

                                    <div
                                        class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                        <div
                                            class="grid grid-cols-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-4 py-2">
                                            <span>Date & Time</span>
                                            <span class="text-right">Checked By</span>
                                        </div>

                                        <div
                                            class="divide-y divide-gray-100 dark:divide-gray-700 max-h-48 overflow-y-auto">
                                            @foreach ($attendee->checkins as $checkin)
                                                <div
                                                    class="grid grid-cols-2 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                                    <div class="text-indigo-600 dark:text-indigo-400 font-medium">
                                                        {{ \Carbon\Carbon::parse($checkin->checkin_time)->format('M j, Y') }}
                                                        <span class="text-indigo-400 dark:text-indigo-300">
                                                            {{ \Carbon\Carbon::parse($checkin->checkin_time)->format('g:i A') }}
                                                        </span>
                                                    </div>
                                                    <div class="text-right text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $checkin->checked_by ?? 'System' }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <label
                                    class="absolute left-5 top-4 px-2 text-gray-500 dark:text-gray-400 text-sm transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded">
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
