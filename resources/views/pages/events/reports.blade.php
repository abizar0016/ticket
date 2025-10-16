<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-3 sm:p-4 md:p-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Header -->
        <div
            class="lg:col-span-12 relative overflow-hidden rounded-xl sm:rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-gray-800 dark:to-gray-700 p-6 sm:p-8 mb-6 shadow-lg sm:shadow-2xl transition-all duration-500 hover:shadow-xl sm:hover:shadow-3xl group">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6">
                <div class="flex items-center gap-4 sm:gap-6">
                    <div
                        class="p-3 sm:p-4 rounded-lg sm:rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-md sm:shadow-lg">
                        <i class="ri-file-warning-line text-2xl sm:text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                            Customer Reports
                        </h1>
                        <p class="text-indigo-600/80 dark:text-indigo-400 text-base sm:text-lg mt-1 sm:mt-2">
                            Semua laporan pelanggan untuk event
                            <span class="font-semibold">{{ $event->title ?? 'Unknown Event' }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div
                class="absolute -right-6 -top-6 sm:-right-10 sm:-top-10 text-black/10 dark:text-white/10 text-7xl sm:text-9xl z-0">
                <i class="ri-file-warning-line"></i>
            </div>
        </div>

        <!-- Stats -->
        <div class="lg:col-span-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-md border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Total Reports</p>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                    {{ $customersReports->total() }}
                </h3>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-md border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Unread Reports</p>
                <h3 class="text-xl sm:text-2xl font-bold text-red-600 dark:text-red-400 mt-1">
                    {{ $customersReports->where('status', 'unread')->count() }}
                </h3>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-md border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Resolved Reports</p>
                <h3 class="text-xl sm:text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                    {{ $customersReports->where('status', 'resolved')->count() }}
                </h3>
            </div>
        </div>

        <!-- Filter -->
        <div
            class="lg:col-span-12 bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-md border border-gray-100 dark:border-gray-700">
            <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                <div class="flex-1 relative group">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500">
                        <i class="ri-filter-3-line"></i>
                    </div>
                    <select name="status" onchange="this.form.submit()"
                        class="pl-10 pr-4 py-2 border-2 border-gray-200 dark:border-gray-700 rounded-lg sm:rounded-xl focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none w-full bg-white dark:bg-gray-900 dark:text-gray-100 text-sm sm:text-base transition-all duration-300 group-hover:border-indigo-300">
                        <option value="">Semua Status</option>
                        @foreach ([
        'unread' => 'Unread',
        'read' => 'Read',
        'replied' => 'Replied',
        'escalated' => 'Escalated',
        'resolved' => 'Resolved',
        'dismissed' => 'Dismissed',
    ] as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Reports Table -->
        <div
            class="lg:col-span-12 bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl overflow-hidden shadow-md border border-gray-100 dark:border-gray-700">
            <div
                class="px-4 py-3 sm:px-6 sm:py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 dark:text-gray-100">All Reports</h3>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                    Showing {{ $customersReports->firstItem() }}–{{ $customersReports->lastItem() }}
                    of {{ $customersReports->total() }}
                </p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th
                                class="px-4 py-2 sm:px-6 sm:py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                User</th>
                            <th
                                class="px-4 py-2 sm:px-6 sm:py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Reason</th>
                            <th
                                class="px-4 py-2 sm:px-6 sm:py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Description</th>
                            <th
                                class="px-4 py-2 sm:px-6 sm:py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-4 py-2 sm:px-6 sm:py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Date</th>
                            <th
                                class="px-4 py-2 sm:px-6 sm:py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($customersReports as $report)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-4 py-3 sm:px-6 sm:py-4 text-gray-900 dark:text-gray-100 font-medium">
                                    {{ $report->user->name ?? 'Unknown User' }}
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 text-gray-700 dark:text-gray-300">
                                    {{ $report->reason ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 sm:px-6 sm:py-4 text-gray-600 dark:text-gray-400 max-w-xs truncate">
                                    {{ Str::limit($report->description, 60) }}
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4">
                                    @php
                                        $statusColors = [
                                            'unread' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200',
                                            'read' =>
                                                'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200',
                                            'replied' =>
                                                'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200',
                                            'escalated' =>
                                                'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200',
                                            'resolved' =>
                                                'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200',
                                            'dismissed' =>
                                                'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                        ];
                                    @endphp
                                    <span
                                        class="px-2 py-1 rounded-lg text-xs font-medium {{ $statusColors[$report->status] ?? 'bg-gray-100 dark:bg-gray-800' }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td
                                    class="px-4 py-3 sm:px-6 sm:py-4 text-center text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $report->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 text-center flex justify-center gap-2">
                                    <a href="{{ route('admin.events.reports.show', [$report->event_id, $report->id]) }}"
                                        class="inline-flex items-center gap-1 px-2 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 rounded-md hover:bg-indigo-200 dark:hover:bg-indigo-800 transition text-xs">
                                        <i class="ri-eye-line"></i> View
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    Tidak ada laporan ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 sm:px-6 sm:py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $customersReports->links() }}
            </div>
        </div>
    </div>
</div>
