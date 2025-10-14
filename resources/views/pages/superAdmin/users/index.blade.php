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
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                <tr class="text-left">
                    <th class="px-6 py-3 text-sm font-medium">No.</th>
                    <th class="px-6 py-3 text-sm font-medium">Name</th>
                    <th class="px-6 py-3 text-sm font-medium">Email</th>
                    <th class="px-6 py-3 text-sm font-medium">Role</th>
                    <th class="px-6 py-3 text-sm font-medium">Created At</th>
                    <th class="px-6 py-3 text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm font-medium truncate max-w-xs" title="{{ $user->name }}">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4 text-sm truncate max-w-xs" title="{{ $user->email }}">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @php
                            $roleColors = [
                                'superadmin' => 'purple',
                                'admin' => 'red',
                                'customer' => 'blue',
                            ];
                            $color = $roleColors[$user->role] ?? 'gray';
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $color }}-100 dark:bg-{{ $color }}-900 text-{{ $color }}-700 dark:text-{{ $color }}-400">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex gap-2">
                            <a href="#"
                               class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-600 dark:text-yellow-200 bg-yellow-50 dark:bg-yellow-900 rounded hover:bg-yellow-100">
                                <i class="ri-edit-line mr-1"></i>Edit
                            </a>
                            <a href="#"
                               class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-600 dark:text-red-200 bg-red-50 dark:bg-red-900 rounded hover:bg-red-100">
                                <i class="ri-delete-bin-6-line mr-1"></i>Delete
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
