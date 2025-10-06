<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 overflow-x-auto">
        <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 text-sm font-medium text-left">No.</th>
                    <th class="px-6 py-3 text-sm font-medium text-left">Name</th>
                    <th class="px-6 py-3 text-sm font-medium text-left">Created By</th>
                    <th class="px-6 py-3 text-sm font-medium text-left">Created At</th>
                    <th class="px-6 py-3 text-sm font-medium text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text=gray-800 dark:text-gray-100">
                @forelse($organizations as $org)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium">{{ $org->name }}</td>
                        <td class="px-6 py-4">
                            {{ $org->user->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $org->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="#"
                                    class="px-2 py-1 text-xs rounded-md bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 flex items-center space-x-1">
                                    <i class="ri-eye-line"></i><span>View</span>
                                </a>
                                <a href="#"
                                    class="px-2 py-1 text-xs rounded-md bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 flex items-center space-x-1">
                                    <i class="ri-edit-line"></i><span>Edit</span>
                                </a>
                                <a href="#"
                                    class="px-2 py-1 text-xs rounded-md bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 flex items-center space-x-1">
                                    <i class="ri-delete-bin-line"></i><span>Delete</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No organizations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $organizations->links() }}
        </div>
    </div>
</div>
