<div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8 font-sans">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-xl md:rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 p-6 md:p-8 mb-6 md:mb-8 shadow-md hover:shadow-lg transition-all duration-300">
        <div class="flex items-center gap-4 md:gap-6 z-10 relative">
            <div class="p-3 md:p-4 rounded-lg md:rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-md">
                <i class="ri-qr-code-line text-2xl md:text-3xl"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">Check-ins</h1>
                <p class="text-indigo-600/80 text-sm md:text-base lg:text-lg mt-1 md:mt-2">Manage your event participants</p>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 md:mb-8">
        <!-- Scanner Column (3/4 width) -->
        <div class="lg:col-span-3 space-y-4 sm:space-y-6">
            <!-- Scanner Card -->
            <div class="bg-white rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-4 sm:p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <h2 class="text-lg sm:text-xl font-semibold flex items-center gap-2">
                        <i class="ri-qr-scan-2-line text-indigo-600"></i>
                        QR Code Scanner
                    </h2>
                    <button id="manual-entry-btn" class="text-indigo-600 hover:text-indigo-800 text-xs sm:text-sm font-medium flex items-center gap-1">
                        <i class="ri-keyboard-line"></i> Manual Entry
                    </button>
                </div>

                <!-- Enhanced Scanner UI -->
                <div class="p-4 sm:p-6">
                    <div class="relative mx-auto max-w-md">
                        <!-- Scanner Frame -->
                        <div class="relative aspect-square overflow-hidden rounded-xl md:rounded-2xl bg-gray-100">
                            <!-- Live Camera Video -->
                            <video id="qr-video" class="w-full h-full object-cover" playsinline autoplay></video>

                            <!-- Scanner Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="relative w-[80%] h-[80%] overflow-hidden z-10 rounded-lg md:rounded-xl" style="box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.6);">
                                    <div class="absolute top-0 left-0 w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12 border-t-2 sm:border-t-3 md:border-t-4 border-l-2 sm:border-l-3 md:border-l-4 border-indigo-400 rounded-tl-lg md:rounded-tl-xl"></div>
                                    <div class="absolute top-0 right-0 w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12 border-t-2 sm:border-t-3 md:border-t-4 border-r-2 sm:border-r-3 md:border-r-4 border-indigo-400 rounded-tr-lg md:rounded-tr-xl"></div>
                                    <div class="absolute bottom-0 left-0 w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12 border-b-2 sm:border-b-3 md:border-b-4 border-l-2 sm:border-l-3 md:border-l-4 border-indigo-400 rounded-bl-lg md:rounded-bl-xl"></div>
                                    <div class="absolute bottom-0 right-0 w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12 border-b-2 sm:border-b-3 md:border-b-4 border-r-2 sm:border-r-3 md:border-r-4 border-indigo-400 rounded-br-lg md:rounded-br-xl"></div>

                                    <div class="absolute top-0 left-0 right-0 h-1 bg-indigo-400/80 rounded-full animate-scan z-10">
                                        <div class="absolute inset-0 bg-indigo-400 blur-sm"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Indicator -->
                            <div class="absolute bottom-3 sm:bottom-4 left-0 right-0 flex justify-center z-20">
                                <div id="scan-status" class="px-2 sm:px-3 py-1 bg-black/70 text-white rounded-full text-xs sm:text-sm flex items-center gap-1">
                                    Ready to scan
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scan Results -->
                    <div id="scan-result" class="mt-4 sm:mt-6 hidden">
                        <div class="bg-indigo-50 rounded-lg md:rounded-xl p-3 sm:p-4 flex items-start gap-3 sm:gap-4">
                            <div class="bg-indigo-100 p-2 sm:p-3 rounded-md sm:rounded-lg text-indigo-600">
                                <i class="ri-user-received-line text-lg sm:text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900 text-sm sm:text-base">Attendee Found</h3>
                                <p id="attendee-name" class="text-gray-600 text-xs sm:text-sm">Loading attendee details...</p>
                            </div>
                            <button id="confirm-checkin" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors">
                                Check In
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (1/4 width) -->
        <div class="space-y-4 sm:space-y-6">
            <!-- Stats Card -->
            @php
                $checkedIn = ($checkedInCount / $totalAttendees) * 100;
                $remaining = 100 - $checkedIn;

                $circumference = 283; // 2πr with r = 45
                $checkedOffset = $circumference * (1 - $checkedIn / 100);
                $remainingOffset = $circumference * (1 - $remaining / 100);
            @endphp

            <div class="bg-white shadow-lg hover:shadow-xl rounded-xl md:rounded-2xl p-4 sm:p-6 h-full transition-shadow duration-300">
                <h3 class="text-base sm:text-lg font-semibold mb-4 sm:mb-6 flex items-center gap-2 text-gray-800">
                    <i class="ri-pie-chart-2-line text-indigo-500"></i>
                    Check-In Stats
                </h3>

                <div class="flex justify-center">
                    <div class="relative w-32 sm:w-40 md:w-48 h-32 sm:h-40 md:h-48">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <!-- Total Track -->
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#e5e7eb" stroke-width="8" />

                            <!-- Checked In Segment -->
                            <circle class="stroke-indigo-500" cx="50" cy="50" r="45" fill="none" 
                                stroke-width="8" stroke-dasharray="{{ $circumference }}" 
                                stroke-dashoffset="{{ $checkedOffset }}" stroke-linecap="round" />

                            <!-- Remaining Segment -->
                            <circle class="stroke-yellow-400" cx="50" cy="50" r="45" fill="none" 
                                stroke-width="8" stroke-dasharray="{{ $circumference }}" 
                                stroke-dashoffset="{{ $circumference + $checkedOffset }}" stroke-linecap="round" />

                            <!-- Center Text -->
                            <text x="50" y="50" text-anchor="middle" dy=".3em" font-size="14" fill="#1f2937" 
                                font-weight="600" transform="rotate(90 50 50)">
                                {{ number_format($checkedIn, 0) }}%
                            </text>
                        </svg>
                    </div>
                </div>

                <div class="mt-4 sm:mt-6 space-y-1 sm:space-y-2 text-xs sm:text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Total Attendees</span>
                        <span class="font-semibold text-gray-800">{{ $totalAttendees }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Checked In</span>
                        <span class="font-semibold text-indigo-500">{{ $checkedInCount }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Remaining</span>
                        <span class="font-semibold text-yellow-400">{{ $remainingCount }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendees Table -->
        <div class="lg:col-span-4 bg-white shadow-lg hover:shadow-xl rounded-xl md:rounded-2xl overflow-hidden transition-shadow duration-300">
            <div class="p-4 sm:p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                <h2 class="text-lg sm:text-xl font-semibold flex items-center gap-2">
                    <i class="ri-user-list-line text-indigo-600"></i>
                    Attendee List
                </h2>
                <div class="w-full sm:w-auto">
                    <form class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="ri-search-line"></i>
                        </div>
                        <input type="text" placeholder="Search attendees..."
                            class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg md:rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-64 transition-all text-xs sm:text-sm">
                    </form>
                </div>
            </div>

            <!-- Modern Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attendee</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($attendees as $attendee)
                            <tr class="hover:bg-gray-50 transition-colors" data-ticket="{{ $attendee->ticket_code }}">
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        <div class="flex-shrink-0 h-8 sm:h-10 w-8 sm:w-10 rounded-full bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center text-white font-medium text-sm sm:text-base">
                                            {{ substr($attendee->name, 0, 1) }}{{ substr(strstr($attendee->name, ' '), 1, 1) ?? '' }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 text-sm sm:text-base">{{ $attendee->name }}</div>
                                            <div class="text-gray-500 text-xs">{{ $attendee->order->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-900 font-mono text-xs sm:text-sm">{{ $attendee->ticket_code }}</div>
                                    <div class="text-gray-500 text-xs">{{ $attendee->ticket_type }}</div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    @if ($attendee->status === 'used')
                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <i class="ri-checkbox-circle-line mr-1"></i> Checked In
                                        </span>
                                        @if ($attendee->last_checkin_at)
                                            <div class="text-gray-500 text-xs mt-1">
                                                {{ \Carbon\Carbon::parse($attendee->last_checkin_at)->setTimezone($tz)->format('M j, Y g:i A') }}
                                            </div>
                                        @endif
                                    @elseif ($attendee->status === 'active')
                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="ri-checkbox-circle-line mr-1"></i> Active
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            <i class="ri-time-line mr-1"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                                    <div class="flex justify-end items-center gap-1 sm:gap-2">
                                        @if ($attendee->checked_in_at)
                                            <button class="text-gray-400 cursor-not-allowed p-1 sm:p-2" title="Already checked in">
                                                <i class="ri-check-line text-base sm:text-lg"></i>
                                            </button>
                                        @else
                                            <button class="text-indigo-600 hover:text-indigo-900 p-1 sm:p-2 checkin-btn" 
                                                data-ticket="{{ $attendee->ticket_code }}" title="Check in">
                                                <i class="ri-user-received-line text-base sm:text-lg"></i>
                                            </button>
                                        @endif
                                        <button class="text-gray-600 hover:text-gray-900 p-1 sm:p-2" title="View details">
                                            <i class="ri-eye-line text-base sm:text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="ri-user-unfollow-line text-3xl sm:text-4xl mb-2"></i>
                                        <p class="text-sm sm:text-base">No attendees found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="mt-4">
        {{ $attendees->links('pagination::default') }}
    </div>
</div>

<!-- Manual Check-In Modal -->
<div id="manual-checkin-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-xl md:rounded-2xl overflow-hidden w-full max-w-md transform transition-all">
        <div class="p-4 sm:p-6">
            <div class="flex items-start gap-3 sm:gap-4">
                <div class="flex-shrink-0 p-2 sm:p-3 rounded-md sm:rounded-lg bg-indigo-100 text-indigo-600">
                    <i class="ri-keyboard-line text-lg sm:text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1 sm:mb-2">Manual Check-In</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">Enter ticket code or attendee details</p>

                    <div class="space-y-3 sm:space-y-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Ticket Code</label>
                            <input type="text" class="w-full px-3 sm:px-4 py-2 border border-gray-200 rounded-lg md:rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-xs sm:text-sm" 
                                   placeholder="ABC123XYZ">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 flex justify-end gap-2 sm:gap-3">
            <button id="cancel-manual-checkin" class="px-3 sm:px-4 py-1.5 sm:py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors text-xs sm:text-sm">
                Cancel
            </button>
            <button class="px-3 sm:px-4 py-1.5 sm:py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors text-xs sm:text-sm">
                Check In
            </button>
        </div>
    </div>
</div>

<form action="{{ route('checkin.process') }}" method="POST" class="hidden" id="checkin-form">
    @csrf
    @method('POST')
    <input type="hidden" name="ticket_code" id="ticket-code-input">
</form>

<div id="success-toast" class="fixed bottom-4 sm:bottom-6 right-4 sm:right-6 z-50 hidden">
    <div class="bg-green-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg md:rounded-xl shadow-lg flex items-center gap-2 sm:gap-3 animate-fade-in-up">
        <i class="ri-checkbox-circle-fill text-xl sm:text-2xl"></i>
        <div>
            <div class="font-medium text-sm sm:text-base">Check-in Successful</div>
            <div class="text-xs sm:text-sm opacity-90">Attendee successfully checked in</div>
        </div>
    </div>
</div>

<style>
    @keyframes scan {
        0% { top: 0%; }
        50% { top: 100% }
        100% { top: 0%; }
    }
    .animate-scan {
        animation: scan 2s ease-in-out infinite;
        position: absolute;
    }

    @keyframes fade-in-up {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.3s ease-out forwards;
    }
</style>

<script type="module">
    import QrScanner from "https://unpkg.com/qr-scanner@1.4.2/qr-scanner.min.js";

    const video = document.getElementById('qr-video');
    const form = document.getElementById('checkin-form');
    const ticketCodeInput = document.getElementById('ticket-code-input');
    const toast = document.getElementById('success-toast');
    const scanStatus = document.getElementById('scan-status');
    const manualEntryBtn = document.getElementById('manual-entry-btn');
    const manualCheckinModal = document.getElementById('manual-checkin-modal');
    const cancelManualCheckin = document.getElementById('cancel-manual-checkin');

    let isProcessing = false;

    const successSound = new Audio('/Audio/mixkit-confirmation-tone-2867.wav');
    const failSound = new Audio('/Audio/mixkit-losing-bleeps-2026.wav');
    const scanSound = new Audio('/Audio/mixkit-confirmation-tone-2867.wav');

    // Manual check-in modal handlers
    manualEntryBtn.addEventListener('click', () => {
        manualCheckinModal.classList.remove('hidden');
    });

    cancelManualCheckin.addEventListener('click', () => {
        manualCheckinModal.classList.add('hidden');
    });

    // QR Scanner
    const scanner = new QrScanner(video, async result => {
        if (isProcessing) return;
        isProcessing = true;

        // UI update
        scanStatus.innerHTML = `<i class="ri-check-line"></i> Processing...`;
        scanStatus.className = 'px-2 sm:px-3 py-1 bg-black/70 text-yellow-400 rounded-full text-xs sm:text-sm flex items-center gap-1';

        ticketCodeInput.value = result;
        video.classList.add('border-green-500');

        scanSound.play().catch(e => console.log('Scan sound error:', e));

        try {
            const response = await fetch(form.action, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new URLSearchParams(new FormData(form))
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // ✅ SUCCESS
                scanStatus.innerHTML = `<i class="ri-check-double-line"></i> Success!`;
                scanStatus.className = 'px-2 sm:px-3 py-1 bg-black/70 text-green-400 rounded-full text-xs sm:text-sm flex items-center gap-1';

                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 3000);

                successSound.play().catch(e => console.log('Success sound error:', e));
            } else {
                // ❌ ERROR
                scanStatus.innerHTML = `<i class="ri-close-line"></i> ${data.message || 'Error'}`;
                scanStatus.className = 'px-2 sm:px-3 py-1 bg-black/70 text-red-400 rounded-full text-xs sm:text-sm flex items-center gap-1';

                failSound.play().catch(e => console.log('Fail sound error:', e));

                Swal.fire({
                    icon: 'error',
                    title: 'Check-in Failed',
                    text: data.message || 'An error occurred',
                    confirmButtonColor: '#EF4444'
                });
            }
        } catch (error) {
            console.error('Network Error:', error);
            scanStatus.innerHTML = `<i class="ri-error-warning-line"></i> Network Error`;
            scanStatus.className = 'px-2 sm:px-3 py-1 bg-black/70 text-red-400 rounded-full text-xs sm:text-sm flex items-center gap-1';

            failSound.play().catch(e => console.log('Fail sound error:', e));

            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'Please check your connection',
                confirmButtonColor: '#EF4444'
            });
        } finally {
            setTimeout(() => {
                video.classList.remove('border-green-500');
                scanStatus.innerHTML = `<i class="ri-search-line"></i> Ready to scan`;
                scanStatus.className = 'px-2 sm:px-3 py-1 bg-black/70 text-white rounded-full text-xs sm:text-sm flex items-center gap-1';
                isProcessing = false;
            }, 2000);
        }
    });

    scanner.start().then(() => {
        console.log('Scanner started');
    }).catch(err => {
        console.error('Error starting scanner:', err);
        scanStatus.innerHTML = `<i class="ri-error-warning-line"></i> Camera Error`;
        scanStatus.className = 'px-2 sm:px-3 py-1 bg-black/70 text-red-400 rounded-full text-xs sm:text-sm flex items-center gap-1';

        failSound.play().catch(e => console.log('Fail sound error:', e));

        Swal.fire({
            icon: 'error',
            title: 'Camera Error',
            text: 'Please allow camera access',
            confirmButtonColor: '#EF4444'
        });
    });

    // Handle manual check-in from table rows
    document.querySelectorAll('.checkin-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const ticketCode = this.getAttribute('data-ticket');
            ticketCodeInput.value = ticketCode;
            
            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: new URLSearchParams(new FormData(form))
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    toast.classList.remove('hidden');
                    setTimeout(() => toast.classList.add('hidden'), 3000);
                    successSound.play().catch(e => console.log('Success sound error:', e));
                    location.reload(); // Refresh to update status
                } else {
                    failSound.play().catch(e => console.log('Fail sound error:', e));
                    Swal.fire({
                        icon: 'error',
                        title: 'Check-in Failed',
                        text: data.message || 'An error occurred',
                        confirmButtonColor: '#EF4444'
                    });
                }
            } catch (error) {
                console.error('Network Error:', error);
                failSound.play().catch(e => console.log('Fail sound error:', e));
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Please check your connection',
                    confirmButtonColor: '#EF4444'
                });
            }
        });
    });
</script>