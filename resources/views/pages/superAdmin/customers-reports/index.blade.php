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

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 overflow-x-auto">
            <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3 text-sm font-medium text-center">No.</th>
                        <th class="px-6 py-3 text-sm font-medium">Title</th>
                        <th class="px-6 py-3 text-sm font-medium">Message</th>
                        <th class="px-6 py-3 text-sm font-medium">User</th>
                        <th class="px-6 py-3 text-sm font-medium">Event</th>
                        <th class="px-6 py-3 text-sm font-medium">Status</th>
                        <th class="px-6 py-3 text-sm font-medium">Created At</th>
                        <th class="px-6 py-3 text-sm font-medium text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-800 dark:text-gray-100">
                    @forelse($customersReports as $report)
                        <tr>
                            <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium">{{ $report->title }}</td>
                            <td class="px-6 py-4">{{ Str::limit($report->message, 50) }}</td>
                            <td class="px-6 py-4">{{ $report->user->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $report->event->title ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs rounded-md
                                @if ($report->status === 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200
                                @elseif($report->status === 'resolved') bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200
                                @else bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200 @endif">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $report->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="#"
                                        class="px-2 py-1 text-xs rounded-md bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 flex items-center space-x-1">
                                        <i class="ri-eye-line"></i><span>View</span>
                                    </a>
                                    <button
                                        class="px-2 py-1 text-xs rounded-md bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 flex items-center space-x-1"
                                        onclick="openReplyModal({{ $report->id }}, '{{ $report->title }}')">
                                        <i class="ri-reply-line"></i><span>Reply</span>
                                    </button>
                                    <a href="#"
                                        class="px-2 py-1 text-xs rounded-md bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 flex items-center space-x-1">
                                        <i class="ri-delete-bin-line"></i><span>Delete</span>
                                    </a>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No reports found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    <div class="mt-4">
        {{ $customersReports->links() }}
    </div>
</div>
