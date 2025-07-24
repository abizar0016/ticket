<div class="min-h-screen bg-white p-6">
    <!-- Header Section -->
    <div
        class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 p-8 mb-8 shadow-lg transition-all duration-500 hover:shadow-xl">
        <div class="flex items-center gap-6 z-10 relative">
            <div
                class="p-4 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg animate-[pulse_3s_ease-in-out_infinite]">
                <i class="ri-user-follow-line text-3xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Event Check-In</h1>
                <p class="text-indigo-600/80 text-lg mt-2">Manage attendee check-ins for {{ $event->title }}</p>
            </div>
        </div>
        <div class="absolute -right-10 -top-10 text-purple-100/40 text-9xl z-0">
            <i class="ri-user-received-2-fill"></i>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Check-In List -->
        <div class="lg:col-span-3">
            <!-- Search and Filter Bar -->
            <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-gray-100">
                <form action="" method="GET">
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="relative w-full md:w-96 group">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors">
                                <i class="ri-search-line"></i>
                            </div>
                            <input type="hidden" name="content" value="{{ request('content') }}">
                            <input type="text" id="search-checkin" placeholder="Search attendees..." name="search"
                                value="{{ request('search') }}"
                                class="bg-white border-2 border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 transition-all duration-300 group-hover:shadow-md">
                        </div>

                        <div class="flex gap-2 w-full md:w-auto">
                            <button type="submit"
                                class="px-4 py-2.5 border-2 border-transparent rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-sm font-medium text-white hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 flex items-center gap-2">
                                <i class="ri-search-line"></i> Search
                            </button>
                            <select name="status"
                                class="px-4 py-2.5 border-2 border-gray-200 rounded-xl bg-white text-sm font-medium text-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300">
                                <option value="">All Status</option>
                                <option value="checked" {{ request('status') == 'checked' ? 'selected' : '' }}>Checked
                                    In</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- QR Scanner Section -->
            <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-gray-100">
                <div class="flex flex-col items-center">
                    <div class="w-full max-w-md border-4 border-dashed border-gray-200 rounded-xl p-4 mb-4"
                        id="scanner-container">
                        <div
                            class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                            <i class="ri-qr-scan-line text-5xl"></i>
                        </div>
                    </div>
                    <button type="button" id="start-scanner"
                        class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 text-sm font-medium text-white hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 flex items-center gap-2">
                        <i class="ri-camera-line"></i> Start QR Scanner
                    </button>
                </div>
            </div>

            <!-- Attendees Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ticket
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Attendee</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Check-In Time</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="checkin-list">
                            @forelse($attendees as $attendee)
                                <tr class="hover:bg-gray-50 transition-colors duration-200"
                                    data-ticket="{{ $attendee->ticket_code }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 p-2 rounded-lg bg-gray-100">
                                                <i class="ri-ticket-2-line text-gray-500"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $attendee->ticket_code }}
                                                </div>
                                                <div class="text-gray-500 text-sm">{{ $attendee->ticket_type }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 flex items-center justify-center text-white font-bold">
                                                {{ substr($attendee->name, 0, 1) }}{{ substr(strstr($attendee->name, ' '), 1, 1) ?? '' }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $attendee->name }}</div>
                                                <div class="text-gray-500 text-sm">Order {{ $attendee->order->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        @if ($attendee->checked_in_at)
                                            {{ $attendee->checked_in_at->format('M d, Y H:i') }}
                                        @else
                                            <span class="text-gray-400">Not checked in</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($attendee->checked_in_at)
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium flex items-center gap-1 w-fit">
                                                <i class="ri-checkbox-circle-line"></i> Checked In
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 font-medium flex items-center gap-1 w-fit">
                                                <i class="ri-close-circle-line"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center gap-3">
                                            @if ($attendee->checked_in_at)
                                                <span class="text-gray-400 cursor-not-allowed"
                                                    title="Already checked in">
                                                    <i class="ri-check-line text-lg"></i>
                                                </span>
                                            @else
                                                <button
                                                    class="text-green-600 hover:text-green-800 checkin-btn transition"
                                                    data-ticket="{{ $attendee->ticket_code }}" title="Check in">
                                                    <i class="ri-user-received-line text-lg"></i>
                                                </button>
                                            @endif

                                            <!-- Delete button -->
                                            <form action="" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this attendee?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 transition" title="Delete">
                                                    <i class="ri-delete-bin-line text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center space-y-2 py-8">
                                            <i class="ri-user-unfollow-line text-4xl text-gray-300"></i>
                                            <p class="text-sm">No attendees found for this event.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Pagination -->
            {{ $attendees->appends(['content' => 'checkins'])->links('pagination::default') }}
        </div>

        <!-- Stats Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                <!-- Summary Card -->
                <div
                    class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-6 shadow-lg border border-indigo-100 transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="ri-dashboard-line text-purple-500"></i>
                        Check-In Stats
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Total Attendees</span>
                                <span class="text-sm font-bold text-gray-900">{{ $totalAttendees }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Checked In</span>
                                <span class="text-sm font-bold text-gray-900">{{ $checkedInCount }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full"
                                    style="width: {{ $checkedInPercentage }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Remaining</span>
                                <span class="text-sm font-bold text-gray-900">{{ $remainingCount }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $remainingPercentage }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Check-Ins -->
                <div
                    class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 shadow-lg border border-blue-100 transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="ri-history-line text-blue-500"></i>
                        Recent Check-Ins
                    </h3>

                    <div class="space-y-4">
                        @forelse($recentCheckIns as $checkin)
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex-shrink-0 h-9 w-9 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold">
                                    {{ substr($checkin->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $checkin->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $checkin->checked_in_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 text-sm py-4">
                                No recent check-ins
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Actions -->
                <div
                    class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 shadow-lg border border-green-100 transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="ri-flashlight-line text-green-500"></i>
                        Quick Actions
                    </h3>

                    <div class="grid grid-cols-2 gap-3">
                        <button
                            class="p-3 rounded-xl bg-white border border-green-200 hover:bg-green-50 transition-all duration-200 flex flex-col items-center justify-center">
                            <i class="ri-printer-line text-green-600 text-xl mb-1"></i>
                            <span class="text-xs font-medium">Print List</span>
                        </button>
                        <button
                            class="p-3 rounded-xl bg-white border border-green-200 hover:bg-green-50 transition-all duration-200 flex flex-col items-center justify-center">
                            <i class="ri-download-line text-green-600 text-xl mb-1"></i>
                            <span class="text-xs font-medium">Export CSV</span>
                        </button>
                        <button
                            class="p-3 rounded-xl bg-white border border-green-200 hover:bg-green-50 transition-all duration-200 flex flex-col items-center justify-center">
                            <i class="ri-mail-send-line text-green-600 text-xl mb-1"></i>
                            <span class="text-xs font-medium">Send Reminder</span>
                        </button>
                        <button
                            class="p-3 rounded-xl bg-white border border-green-200 hover:bg-green-50 transition-all duration-200 flex flex-col items-center justify-center">
                            <i class="ri-qr-code-line text-green-600 text-xl mb-1"></i>
                            <span class="text-xs font-medium">Print QR Codes</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Manual Check-In Modal -->
<div id="manual-checkin-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-r from-green-100 to-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="ri-user-add-line text-green-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Manual Check-In
                        </h3>
                        <div class="mt-2">
                            <div class="space-y-4">
                                <div>
                                    <label for="ticket-code" class="block text-sm font-medium text-gray-700">Ticket
                                        Code</label>
                                    <input type="text" name="ticket-code" id="ticket-code"
                                        class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="attendee-search" class="block text-sm font-medium text-gray-700">Or
                                        Search Attendee</label>
                                    <input type="text" name="attendee-search" id="attendee-search"
                                        class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                <button type="button"
                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-base font-medium text-white hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Check In
                </button>
                <button type="button" id="cancel-manual-checkin"
                    class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // QR Scanner functionality
        document.getElementById('start-scanner').addEventListener('click', function() {
            // Implement QR scanner logic here
            alert('QR Scanner functionality would be implemented here');
        });

        // Manual check-in modal
        const modal = document.getElementById('manual-checkin-modal');
        document.getElementById('checkin-btn').addEventListener('click', function() {
            modal.classList.remove('hidden');
        });

        document.getElementById('cancel-manual-checkin').addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // Check-in buttons
        document.querySelectorAll('.checkin-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const ticketCode = this.getAttribute('data-ticket');
                // Implement check-in logic here
                alert(`Checking in ticket: ${ticketCode}`);
            });
        });

        // Search functionality
        document.getElementById('search-checkin').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('#checkin-list tr').forEach(row => {
                const ticketCode = row.getAttribute('data-ticket').toLowerCase();
                if (ticketCode.includes(searchTerm)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
