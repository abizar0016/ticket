<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900">
                Users
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                Manage all users
            </p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr class="text-center">
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">No. </th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Created At</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @switch($user->role)
                                @case('superadmin')
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-700">
                                        Super Admin
                                    </span>
                                @break

                                @case('admin')
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                        Admin
                                    </span>
                                @break

                                @case('customer')
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
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
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-600 bg-yellow-50 rounded hover:bg-yellow-100">
                                    <i class="ri-edit-line mr-1"></i>
                                    Edit
                                </a>

                                <!-- Delete -->
                                <a href="#"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-600 bg-red-50 rounded hover:bg-red-100">
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
