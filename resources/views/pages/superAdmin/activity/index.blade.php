<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="ri-history-line text-indigo-500"></i>
                    Activity Logs
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Monitor all system activities and actions by users.</p>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('superAdmin.activities') }}"
                class="flex items-center bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden w-full sm:w-80 shadow-sm">
                <input type="text" name="search" placeholder="Search activity..."
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 bg-transparent text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none">
                <button type="submit"
                    class="px-3 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                    <i class="ri-search-line text-lg"></i>
                </button>
            </form>
        </div>

        <!-- Table -->
        <div
            class="overflow-hidden rounded-xl shadow-md border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-800">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Action
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Time
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider text-center">
                            Details
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($activities as $activity)
                        <tr
                            class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="h-8 w-8 flex items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300">
                                        <i class="ri-user-line text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $activity->user->name ?? 'Unknown User' }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            ID: {{ $activity->user_id ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ $activity->action }}
                            </td>

                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $activity->created_at->diffForHumans() }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($activity->link)
                                    <a href="{{ $activity->link }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs rounded-md font-medium bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                                        <i class="ri-eye-line text-sm"></i> View
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                                No activity logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $activities->links() }}
        </div>
    </div>
</div>
