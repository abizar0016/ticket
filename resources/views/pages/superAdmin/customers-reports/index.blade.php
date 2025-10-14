<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                Reports
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                Manage all customer reports
            </p>
        </div>
    </div>

    <!-- Reports Cards -->
    <div class="space-y-4">
        @forelse($customersReports as $report)
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-4 sm:p-6 hover:shadow-xl transition transform hover:-translate-y-0.5">

            <!-- Top Row: No, Reason, User, Status -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                <div class="flex items-center gap-3">
                    <!-- Nomor urut -->
                    <span class="text-gray-400 dark:text-gray-300 font-semibold">#{{ $loop->iteration }}</span>

                    <!-- Reason & User -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <p class="font-medium text-gray-800 dark:text-gray-100">{{ $report->reason ?? 'No reason' }}</p>
                        <span class="text-gray-500 dark:text-gray-400 text-sm">by {{ $report->user->name ?? '-' }}</span>
                    </div>
                </div>

                <!-- Status -->
                <div class="mt-2 sm:mt-0">
                    @php
                        $statusColors = [
                            'unread' => 'bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200',
                            'read' => 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200',
                            'replied' => 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200',
                            'escalated' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200',
                            'resolved' => 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200',
                            'dismissed' => 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$report->status] ?? 'bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200' }}">
                        {{ ucfirst($report->status) }}
                    </span>
                </div>
            </div>

            <!-- Middle Row: Event & Description -->
            <div class="mt-3 text-sm text-gray-700 dark:text-gray-100">
                <p><span class="font-semibold">Event:</span> {{ $report->event->title ?? '-' }}</p>
                <p class="mt-1"><span class="font-semibold">Message:</span> {{ Str::limit($report->description, 200) }}</p>
            </div>

            <!-- Bottom Row: Created At + Actions -->
            <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                <p class="text-gray-500 dark:text-gray-400 text-xs">Created at: {{ $report->created_at->format('d M Y') }}</p>
                <div class="flex flex-col sm:flex-row gap-2 mt-2 sm:mt-0">
                    <a href="#"
                       class="px-2 py-1 text-xs rounded-md bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 flex items-center space-x-1">
                        <i class="ri-eye-line"></i><span>View</span>
                    </a>
                    <button onclick="openReplyModal({{ $report->id }}, '{{ $report->reason }}')"
                        class="px-2 py-1 text-xs rounded-md bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 flex items-center space-x-1">
                        <i class="ri-reply-line"></i><span>Reply</span>
                    </button>
                    <a href="#"
                       class="px-2 py-1 text-xs rounded-md bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 flex items-center space-x-1">
                        <i class="ri-delete-bin-line"></i><span>Delete</span>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 text-center text-gray-500 dark:text-gray-400">
            No reports found.
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $customersReports->links() }}
    </div>
</div>
