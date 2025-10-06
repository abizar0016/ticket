<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                Users
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                Manage all users
            </p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                <tr class="text-center">
                    <th class="px-6 py-3 text-left text-sm font-medium">No. </th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Created At</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-gray-800 dark:text-gray-100">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @switch($user->role)
                                @case('superadmin')
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-400">
                                        Super Admin
                                    </span>
                                @break

                                @case('admin')
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-400">
                                        Admin
                                    </span>
                                @break

                                @case('customer')
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-400">
                                        Customer
                                    </span>
                                @break
                            @endswitch

                        </td>
                        <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">

                                <!-- Edit -->
                                <a href="#"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-600 dark:text-yellow-200 bg-yellow-50 dark:bg-yellow-900 rounded hover:bg-yellow-100">
                                    <i class="ri-edit-line mr-1"></i>
                                    Edit
                                </a>

                                <!-- Delete -->
                                <a href="#"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-600 dark:text-red-200 bg-red-50 dark:bg-red-900 rounded hover:bg-red-100">
                                    <i class="ri-delete-bin-6-line mr-1"></i>
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

</div>
