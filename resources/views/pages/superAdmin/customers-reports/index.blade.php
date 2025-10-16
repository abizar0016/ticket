<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                Customer Reports
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                Kelola laporan pengguna dari semua event yang terdaftar.
            </p>
        </div>

        <!-- Filter -->
        <form method="GET"
              class="flex flex-wrap sm:flex-nowrap gap-2 bg-white dark:bg-gray-800 
                     border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm px-4 py-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari alasan, user, event..."
                   class="w-full sm:w-64 rounded-lg border border-gray-300 dark:border-gray-700 
                          bg-white dark:bg-gray-900 dark:text-gray-200 text-sm 
                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2 outline-none" />

            <select name="status"
                    class="rounded-lg border border-gray-300 dark:border-gray-700 
                           bg-white dark:bg-gray-900 dark:text-gray-200 text-sm 
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2 outline-none">
                <option value="">Semua Status</option>
                @foreach (['unread', 'read', 'replied', 'escalated', 'resolved', 'dismissed'] as $opt)
                    <option value="{{ $opt }}" @selected(request('status') == $opt)>
                        {{ ucfirst($opt) }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold 
                           hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Total', 'count' => $totalReports, 'color' => 'text-indigo-600 dark:text-indigo-400'],
                ['label' => 'Unread', 'count' => $unreadReports, 'color' => 'text-yellow-600 dark:text-yellow-400'],
                ['label' => 'Resolved', 'count' => $resolvedReports, 'color' => 'text-green-600 dark:text-green-400'],
                ['label' => 'Escalated', 'count' => $escalatedReports, 'color' => 'text-red-600 dark:text-red-400'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 
                        shadow-sm hover:shadow-md transition">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                    {{ $stat['label'] }}
                </p>
                <p class="mt-2 text-2xl sm:text-3xl font-extrabold {{ $stat['color'] }}">{{ $stat['count'] }}</p>
            </div>
        @endforeach
    </div>

    <!-- Table -->
    <div class="dark:bg-gray-800 rounded-xl p-6 overflow-x-auto border border-gray-200 dark:border-gray-700 shadow-xl">
        <table class="min-w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300">
                <tr>
                    @foreach (['User', 'Event', 'Reason', 'Status', 'Tanggal', 'Actions'] as $head)
                        <th class="px-6 py-3 text-sm font-semibold text-left">{{ $head }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($customersReports as $report)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                            {{ $report->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                            {{ $report->event->title ?? 'Tidak ada event' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 text-sm">
                            {{ Str::limit($report->reason ?? '-', 60) }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'unread' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200',
                                    'read' => 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200',
                                    'resolved' => 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200',
                                    'escalated' => 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200',
                                    'replied' => 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200',
                                    'dismissed' => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$report->status] ?? '' }}">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ $report->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 flex items-center space-x-2">
                            <a href="{{ route('superAdmin.reports.show', $report->id) }}"
                               class="px-2 py-1 text-xs rounded-md bg-blue-100 dark:bg-blue-900 
                                      text-blue-700 dark:text-blue-200 flex items-center space-x-1 hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                                <i class="ri-eye-line"></i><span>View</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 text-sm">
                            Belum ada laporan yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4 flex justify-center">
            {{ $customersReports->links() }}
        </div>
    </div>
</div>
</div>