<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-3 sm:p-4 md:p-6 text-gray-900 dark:text-gray-100">
    <!-- Header -->
    <div
        class="relative overflow-hidden rounded-xl md:rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-gray-800 dark:to-gray-700 p-6 md:p-8 mb-6 md:mb-8 shadow-md hover:shadow-lg transition-all duration-300">
        <div class="flex items-center gap-4 md:gap-6 z-10 relative">
            <div
                class="p-3 md:p-4 rounded-lg md:rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-md">
                <i class="ri-qr-code-line text-2xl md:text-3xl"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                    Check-ins
                </h1>
                <p class="text-indigo-600/80 dark:text-indigo-400/80 text-sm md:text-base lg:text-lg mt-1 md:mt-2">
                    Manage your event participants
                </p>
            </div>
        </div>
        <div
            class="absolute right-4 sm:right-6 md:right-10 top-0 text-black/10 dark:text-white/10 text-5xl sm:text-7xl md:text-9xl z-0">
            <i class="ri-qr-code-line"></i>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 md:mb-8">
        <!-- Scanner Column -->
        <div class="lg:col-span-3 space-y-4 sm:space-y-6">
            <!-- Scanner Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div
                    class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <h2 class="text-lg sm:text-xl font-semibold flex items-center gap-2">
                        <i class="ri-qr-scan-2-line text-indigo-600"></i>
                        QR Code Scanner
                    </h2>
                    <button id="manual-entry-btn"
                        class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-xs sm:text-sm font-medium flex items-center gap-1 cursor-pointer">
                        <i class="ri-keyboard-line"></i> Manual Entry
                    </button>
                </div>

                <!-- Scanner UI -->
                <div class="p-4 sm:p-6">
                    <div class="relative mx-auto max-w-md">
                        <div
                            class="relative aspect-square overflow-hidden rounded-xl md:rounded-2xl bg-gray-100 dark:bg-gray-700">
                            <video id="qr-video" class="w-full h-full object-cover" playsinline autoplay></video>

                            <!-- Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="relative w-[80%] h-[80%] overflow-hidden z-10 rounded-lg md:rounded-xl"
                                    style="box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.6);">
                                    <div
                                        class="absolute top-0 left-0 w-10 h-10 border-t-4 border-l-4 border-indigo-400 rounded-tl-lg">
                                    </div>
                                    <div
                                        class="absolute top-0 right-0 w-10 h-10 border-t-4 border-r-4 border-indigo-400 rounded-tr-lg">
                                    </div>
                                    <div
                                        class="absolute bottom-0 left-0 w-10 h-10 border-b-4 border-l-4 border-indigo-400 rounded-bl-lg">
                                    </div>
                                    <div
                                        class="absolute bottom-0 right-0 w-10 h-10 border-b-4 border-r-4 border-indigo-400 rounded-br-lg">
                                    </div>

                                    <!-- Scan Line -->
                                    <div
                                        class="absolute top-0 left-0 right-0 h-1 bg-indigo-400/80 rounded-full animate-scan z-10">
                                        <div class="absolute inset-0 bg-indigo-400 blur-sm"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="absolute bottom-3 sm:bottom-4 left-0 right-0 flex justify-center z-20">
                                <div id="scan-status"
                                    class="px-3 py-1 bg-black/70 text-white rounded-full text-xs sm:text-sm flex items-center gap-1">
                                    Ready to scan
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scan Results -->
                    <div id="scan-result" class="mt-4 sm:mt-6 hidden">
                        <div
                            class="bg-indigo-50 dark:bg-gray-700 rounded-lg md:rounded-xl p-3 sm:p-4 flex items-start gap-4">
                            <div
                                class="bg-indigo-100 dark:bg-indigo-500/30 p-3 rounded-lg text-indigo-600 dark:text-indigo-300">
                                <i class="ri-user-received-line text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900 dark:text-gray-100 text-sm sm:text-base">
                                    Attendee Found
                                </h3>
                                <p id="attendee-name" class="text-gray-600 dark:text-gray-300 text-xs sm:text-sm">
                                    Loading attendee details...
                                </p>
                            </div>
                            <button id="confirm-checkin"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Check In
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="space-y-6">
            @php
                if ($totalAttendees > 0) {
                    $checkedIn = ($checkedInCount / $totalAttendees) * 100;
                } else {
                    $checkedIn = 0;
                }
                $remaining = 100 - $checkedIn;
                $circumference = 283;
                $checkedOffset = $circumference * (1 - $checkedIn / 100);
            @endphp

            <div
                class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl rounded-xl md:rounded-2xl p-6 transition-shadow duration-300">
                <h3 class="text-lg font-semibold mb-6 flex items-center gap-2 text-gray-800 dark:text-gray-200">
                    <i class="ri-pie-chart-2-line text-indigo-500"></i>
                    Check-In Stats
                </h3>
                <div class="flex justify-center">
                    <div class="relative w-40 h-40">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#e5e7eb"
                                stroke-width="8" />
                            <circle class="stroke-indigo-500" cx="50" cy="50" r="45" fill="none"
                                stroke-width="8" stroke-dasharray="{{ $circumference }}"
                                stroke-dashoffset="{{ $checkedOffset }}" stroke-linecap="round" />
                            <text x="50" y="50" text-anchor="middle" dy=".3em" font-size="16"
                                class="text-indigo-500 fill-current" font-weight="600" transform="rotate(90 50 50)">
                                {{ number_format($checkedIn, 0) }}%
                            </text>
                        </svg>
                    </div>
                </div>
                <div class="mt-6 space-y-2 text-sm text-gray-600 dark:text-gray-300">
                    <div class="flex justify-between">
                        <span>Total Attendees</span>
                        <span class="font-semibold">{{ $totalAttendees }}</span>
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
    </div>

    <!-- Attendee Table -->
    <div
        class="lg:col-span-4 bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl rounded-xl md:rounded-2xl overflow-hidden transition-shadow duration-300">
        <div
            class="p-5 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-xl font-semibold flex items-center gap-2">
                <i class="ri-user-list-line text-indigo-600"></i>
                Attendee List
            </h2>
            <form class="relative" method="GET">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="ri-search-line"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                    class="pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-64 transition-all text-sm dark:bg-gray-700 dark:text-gray-200">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Attendee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($attendees as $attendee)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                            data-ticket="{{ $attendee->ticket_code }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center text-white font-medium">
                                        {{ substr($attendee->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $attendee->name }}
                                        </div>
                                        <div class="text-gray-500 text-xs">{{ $attendee->order->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-900 dark:text-gray-200 font-mono text-sm">
                                    {{ $attendee->ticket_code }}
                                </div>
                                <div class="text-gray-500 text-xs">{{ $attendee->ticket_type }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($attendee->status === 'used')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300">
                                        <i class="ri-checkbox-circle-line mr-1"></i> Checked In
                                    </span>
                                @elseif ($attendee->status === 'active')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">
                                        <i class="ri-checkbox-circle-line mr-1"></i> Active
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                        <i class="ri-time-line mr-1"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-2">
                                <button id="open-view-checkins-modal-{{ $attendee->id }}"
                                    class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 cursor-pointer"
                                    title="View" data-id="{{ $attendee->id }}">
                                    <i class="ri-eye-line text-lg"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <div
                                    class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                    <i class="ri-user-unfollow-line text-4xl mb-2"></i>
                                    <p>No attendees found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $attendees->links('pagination::default') }}
    </div>
</div>

@include('modals.checkins.manual')
@include('modals.checkins.view')

<form action="{{ route('checkins.process') }}" method="POST" class="hidden" id="checkin-form">
    @csrf
    <input type="hidden" name="ticket_code" id="ticket-code-input">
</form>

<div id="success-toast"
    class="fixed bottom-6 right-6 z-50 hidden bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3 animate-fade-in-up">
    <i class="ri-checkbox-circle-fill text-2xl"></i>
    <div>
        <div class="font-medium">Check-in Successful</div>
        <div class="text-sm opacity-90">Attendee successfully checked in</div>
    </div>
</div>

<style>
    @keyframes scan {
        0% {
            top: 0%
        }

        50% {
            top: 100%
        }

        100% {
            top: 0%
        }
    }

    .animate-scan {
        animation: scan 2s ease-in-out infinite;
        position: absolute
    }

    @keyframes fade-in-up {
        0% {
            opacity: 0;
            transform: translateY(10px)
        }

        100% {
            opacity: 1;
            transform: translateY(0)
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up .3s ease-out forwards
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
    const manualCheckinForm = document.getElementById('manual-checkin-form');

    let isProcessing = false;

    const successSound = new Audio('/Audio/mixkit-confirmation-tone-2867.wav');
    const failSound = new Audio('/Audio/mixkit-losing-bleeps-2026.wav');
    const scanSound = new Audio('/Audio/mixkit-confirmation-tone-2867.wav');

    manualEntryBtn.addEventListener('click', () => {
        manualCheckinModal.classList.remove('hidden');
    });

    cancelManualCheckin.addEventListener('click', (e) => {
        e.preventDefault();
        manualCheckinModal.classList.add('hidden');
    });

    // === QR Scanner ===
    const scanner = new QrScanner(video, async result => {
        if (isProcessing) return;
        isProcessing = true;

        scanStatus.innerHTML = `<i class="ri-check-line"></i> Processing...`;
        scanStatus.className =
            'px-2 sm:px-3 py-1 bg-black/70 text-yellow-400 rounded-full text-xs sm:text-sm flex items-center gap-1';

        ticketCodeInput.value = result;
        video.classList.add('border-green-500');
        scanSound.play().catch(() => {});

        await handleSubmit(form);

        setTimeout(() => {
            video.classList.remove('border-green-500');
            scanStatus.innerHTML = `<i class="ri-search-line"></i> Ready to scan`;
            scanStatus.className =
                'px-2 sm:px-3 py-1 bg-black/70 text-white rounded-full text-xs sm:text-sm flex items-center gap-1';
            isProcessing = false;
        }, 2000);
    });
    scanner.start().catch(err => {
        console.error('Error starting scanner:', err);
    });

    async function handleSubmit(targetForm) {
        try {
            const response = await fetch(targetForm.action, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new URLSearchParams(new FormData(targetForm))
            });

            const data = await response.json();
            if (response.ok && data.success) {
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 3000);

                successSound.play().catch(() => {});
                manualCheckinModal.classList.add('hidden');
            } else {
                failSound.play().catch(() => {});
                Swal.fire({
                    icon: 'error',
                    title: 'Check-in Failed',
                    text: data.message || 'An error occurred',
                    confirmButtonColor: '#EF4444'
                });
            }
        } catch (err) {
            failSound.play().catch(() => {});
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'Please check your connection',
                confirmButtonColor: '#EF4444'
            });
        }
    }
</script>
