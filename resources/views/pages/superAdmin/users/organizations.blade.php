<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                Organizations
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                Manage all organizations
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
                        <th class="px-6 py-4 text-sm font-semibold">Name</th>
                        <th class="px-6 py-4 text-sm font-semibold">Created By</th>
                        <th class="px-6 py-4 text-sm font-semibold">Created At</th>
                        <th class="px-6 py-4 text-sm font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($organizations as $org)
                        <tr
                            class="hover:shadow-md dark:hover:shadow-gray-700 hover:-translate-y-0.5 transition transform bg-white dark:bg-gray-800">
                            <td class="px-6 py-5 font-semibold text-gray-800 dark:text-gray-100">{{ $loop->iteration }}</td>
                            <td class="px-6 py-5 text-gray-800 dark:text-gray-100 font-medium">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 text-white flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($org->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $org->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-gray-700 dark:text-gray-100">
                                @if ($org->user)
                                    <div class="flex items-center gap-2">
                                        <i class="ri-user-line text-gray-400"></i>
                                        <span>{{ $org->user->name }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-100">
                                {{ $org->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="#"
                                        class="px-2 py-1 text-xs rounded-md bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-800 flex items-center space-x-1">
                                        <i class="ri-eye-line"></i><span>View</span>
                                    </a>
                                    <a href="#"
                                        class="px-2 py-1 text-xs rounded-md bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 hover:bg-yellow-200 dark:hover:bg-yellow-800 flex items-center space-x-1">
                                        <i class="ri-edit-line"></i><span>Edit</span>
                                    </a>
                                    <a href="#"
                                        class="px-2 py-1 text-xs rounded-md bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-800 flex items-center space-x-1">
                                        <i class="ri-delete-bin-line"></i><span>Delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="px-6 py-6 text-center text-gray-500 dark:text-gray-400 italic">
                                No organizations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="block md:hidden space-y-4">
        @forelse ($organizations as $org)
            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-4 sm:p-6 hover:shadow-xl transition transform hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 text-white flex items-center justify-center font-bold">
                            {{ strtoupper(substr($org->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-100">{{ $org->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Created by: {{ $org->user->name ?? '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-gray-700 dark:text-gray-100 space-y-2">
                    <p><span class="font-semibold text-gray-600 dark:text-gray-400">Created at:</span>
                        {{ $org->created_at->format('d M Y, H:i') }}</p>
                </div>

                <div class="flex justify-end gap-2 mt-3">
                    <a href="#"
                        class="px-2 py-1 w-20 text-xs rounded-md bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 flex justify-center items-center space-x-1">
                        <i class="ri-eye-line"></i><span>View</span>
                    </a>
                    <a href="#"
                        class="px-2 py-1 w-20 text-xs rounded-md bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 flex justify-center items-center space-x-1">
                        <i class="ri-edit-line"></i><span>Edit</span>
                    </a>
                    <a href="#"
                        class="px-2 py-1 w-20 text-xs rounded-md bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 flex justify-center items-center space-x-1">
                        <i class="ri-delete-bin-line"></i><span>Delete</span>
                    </a>
                </div>
            </div>
        @empty
            <div
                class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center text-gray-500 dark:text-gray-400 italic">
                No organizations found.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $organizations->links() }}
    </div>
</div>
</div>