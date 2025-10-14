<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                Customer Reports
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                Manage all customer reports
            </p>
        </div>
    </div>

    <!-- Desktop Table -->
    <div
        class="hidden md:block bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold">No.</th>
                        <th class="px-6 py-4 text-sm font-semibold">Reason</th>
                        <th class="px-6 py-4 text-sm font-semibold">User</th>
                        <th class="px-6 py-4 text-sm font-semibold">Event</th>
                        <th class="px-6 py-4 text-sm font-semibold">Message</th>
                        <th class="px-6 py-4 text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-sm font-semibold">Date</th>
                        <th class="px-6 py-4 text-sm font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($customersReports as $report)
                        <tr
                            class="hover:shadow-md dark:hover:shadow-gray-700 hover:-translate-y-0.5 transition transform bg-white dark:bg-gray-800">
                            <td class="px-6 py-5 font-semibold text-gray-800 dark:text-gray-100">{{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-5 text-gray-700 dark:text-gray-100 truncate max-w-3xs">
                                {{ $report->reason ?? 'No reason' }}</td>
                            <td class="px-6 py-5">{{ $report->user->name ?? '-' }}</td>
                            <td class="px-6 py-5">{{ $report->event->title ?? '-' }}</td>
                            <td class="px-6 py-5 truncate max-w-3xs">{{ Str::limit($report->description, 50) }}</td>
                            <td class="px-6 py-5">
                                @php
                                    $statusColors = [
                                        'unread' => 'bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200',
                                        'read' => 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200',
                                        'replied' =>
                                            'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200',
                                        'escalated' =>
                                            'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200',
                                        'resolved' =>
                                            'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200',
                                        'dismissed' => 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$report->status] ?? 'bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-100">
                                {{ $report->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-5 text-right flex justify-end gap-2">
                                <a href="#"
                                    class="px-2 py-1 text-xs rounded-md bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 flex items-center space-x-1">
                                    <i class="ri-eye-line"></i><span>View</span>
                                </a>
                                <a href="#"
                                    class="px-2 py-1 text-xs rounded-md bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 flex items-center space-x-1">
                                    <i class="ri-delete-bin-line"></i><span>Delete</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="block md:hidden space-y-4">
        @foreach ($customersReports as $report)
            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-4 sm:p-6 hover:shadow-xl transition transform hover:-translate-y-0.5">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                    <div class="flex items-center gap-3">
                        <span class="text-gray-400 dark:text-gray-300 font-semibold">#{{ $loop->iteration }}</span>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-gray-800 dark:text-gray-100">
                                {{ $report->reason ?? 'No reason' }}</p>
                            <span class="text-gray-500 dark:text-gray-400 text-sm">by
                                {{ $report->user->name ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        <span
                            class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$report->status] ?? 'bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200' }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>
                </div>
                <div class="mt-3 text-sm text-gray-700 dark:text-gray-100">
                    <p><span class="font-semibold">Event:</span> {{ $report->event->title ?? '-' }}</p>
                    <p class="mt-1"><span class="font-semibold">Message:</span>
                        {{ Str::limit($report->description, 200) }}</p>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-xs">Created at:
                    {{ $report->created_at->format('d M Y') }}</p>
                <div class="flex justify-end flex-row gap-2 mt-2 sm:mt-0">
                    <a href="#"
                        class="px-2 py-1 text-xs rounded-md bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 flex items-center space-x-1">
                        <i class="ri-eye-line"></i><span>View</span>
                    </a>
                    <a href="#"
                        class="px-2 py-1 text-xs rounded-md bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 flex items-center space-x-1">
                        <i class="ri-delete-bin-line"></i><span>Delete</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $customersReports->links() }}
    </div>
</div>
