<div class="min-h-screen bg-white p-6">
    <!-- Header Section -->
    <div
        class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 p-8 mb-8 shadow-lg transition-all duration-500 hover:shadow-xl">
        <div class="flex items-center gap-6 z-10 relative">
            <div
                class="p-4 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-lg animate-[pulse_3s_ease-in-out_infinite]">
                <i class="ri-user-line text-3xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Event Attendees</h1>
                <p class="text-indigo-600/80 text-lg mt-2">Manage your event participants</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Attendees List -->
        <div class="lg:col-span-3">
            <!-- Search and Filter Bar -->
            <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-gray-100">
                <form action="" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                    <input type="hidden" name="content" value="{{ request('content') }}">

                    <div class="relative w-full md:w-96 group">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors">
                            <i class="ri-search-line"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search attendees..."
                            class="bg-white border-2 border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 transition-all duration-300 group-hover:shadow-md">
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit"
                            class="px-4 py-2.5 border-2 border-transparent rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-sm font-medium text-white hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 flex items-center gap-2">
                            <i class="ri-search-line"></i> Search
                        </button>
                    </div>
                </form>

            </div>

            <!-- Attendees Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ticket Code</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Registered</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($attendees as $attendee)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 flex items-center justify-center text-white font-bold">
                                                {{ substr($attendee->name, 0, 1) }}{{ substr(strstr($attendee->name, ' '), 1, 1) ?? '' }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $attendee->name }}</div>
                                                <div class="text-gray-500 text-sm">Order {{ $attendee->order->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $attendee->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        {{ $attendee->ticket_code ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($attendee->status === 'active')
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium">Active</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 font-medium">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        {{ $attendee->created_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                        <div class="flex justify-end items-center gap-2">
                                            <button
                                            id="open-attendee-update-modal"
                                                class="p-2 text-indigo-600 hover:text-indigo-800 rounded hover:bg-indigo-50 transition"
                                                title="Edit" data-id="{{ $attendee->id }}">
                                                <i class="ri-edit-line text-xl"></i>
                                            </button>

                                            <form id="delete-attendee-{{ $attendee->id }}" action="{{ route('attendees.destroy', $attendee->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-600 hover:text-red-800 rounded hover:bg-red-50 transition"
                                                    title="Delete">
                                                    <i class="ri-delete-bin-line text-xl"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No attendees found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                {{ $attendees->appends(['content' => 'attendees'])->links('pagination::default') }}
            </div>
        </div>

        <!-- Stats Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                <!-- Summary Card -->
                <div
                    class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6 shadow-lg border border-purple-100 transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="ri-line-chart-line text-purple-500"></i>
                        Attendance Summary
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Total Registered</span>
                                <span class="text-sm font-bold text-gray-900">{{ $totalAttendees }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Active</span>
                                <span class="text-sm font-bold text-gray-900">{{ $activeAttendees }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $activePercentage }}%">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Pending</span>
                                <span class="text-sm font-bold text-gray-900">{{ $pendingAttendees }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $pendingPercentage }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.modal.update-attendees')

<script>
document.querySelectorAll('form[id^="delete-attendee-"]').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the attendee.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const actionUrl = form.getAttribute('action');

                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Deleting...';

                fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    },
                })
                .then(async (res) => {
                    const data = await res.json();

                    if (res.ok && data.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#6366F1'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Oops!',
                            html: (data.errors || ['Failed to delete']).join("<br>"),
                            icon: 'error',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Something went wrong',
                        icon: 'error',
                        confirmButtonColor: '#EF4444'
                    });
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML = '<i class="ri-delete-bin-line mr-2"></i> Delete';
                });
            }
        });
    });
});
</script>
