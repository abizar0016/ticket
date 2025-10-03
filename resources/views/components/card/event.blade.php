<div class="relative overflow-hidden">
    @if ($events->isEmpty())
        <!-- Empty State -->
        <div
            class="relative bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-12 text-center animate-[fadeIn_0.6s_ease-out_forwards] overflow-hidden border border-white/20">
            <div
                class="absolute inset-0 [background-image:radial-gradient(ellipse_at_center,white,transparent_70%)] [mask-image:radial-gradient(ellipse_at_center,white,transparent_70%)]">
            </div>
            <div class="relative z-10">
                <div
                    class="mx-auto w-24 h-24 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                    <i class="ri-calendar-2-line text-4xl"></i>
                </div>
                <h3
                    class="text-2xl font-bold text-gray-900 mb-3 bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600">
                    No events found</h3>
                <p class="text-gray-600/90 mb-8 max-w-md mx-auto text-lg">
                    @switch($eventStatus)
                        @case('draft')
                            No events in draft
                        @break

                        @case('upcoming')
                            No upcoming events scheduled
                        @break

                        @case('ended')
                            No past events in records
                        @break

                        @case('ongoing')
                            No active events currently
                        @break

                        @default
                            There are currently no events available
                    @endswitch
                </p>
                <a href="#"
                    class="relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-medium rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-300 hover:shadow-lg group overflow-hidden">
                    <span
                        class="absolute inset-0 bg-gradient-to-r from-primary-600 to-primary-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <span class="relative z-10 flex items-center">
                        <i class="ri-add-line mr-2 text-lg"></i>
                        <span
                            class="relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-white/70 after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300">Create
                            New Event</span>
                    </span>
                </a>
            </div>
        </div>
    @else
        <!-- Events Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col">

                    {{-- Event Image --}}
                    <div class="h-40 w-full bg-gray-200 dark:bg-gray-800">
                        @if ($event->event_image)
                            <img src="{{ asset($event->event_image) }}" alt="{{ $event->title }}"
                                class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-gray-400">
                                <i class="ri-image-line text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Event Content --}}
                    <div class="p-5 flex-1 flex flex-col">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-2">
                            {{ $event->title }}
                        </h2>

                        <div class="mt-2 grid grid-cols-1 gap-1 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                            <span><i
                                    class="ri-folder-2-line mr-1"></i>Category: {{ $event->categories->name ?? 'Uncategorized' }}</span>
                            <span><i class="ri-user-line mr-1"></i>Created By: {{ $event->user->name ?? 'Unknown' }}</span>
                            <span><i
                                    class="ri-building-2-line mr-1"></i>Organization: {{ $event->organization->name ?? 'No Organization' }}</span>
                        </div>

                        <div class="mt-3">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold 
                            @if ($event->status === 'draft') bg-amber-100 text-amber-700
                            @elseif ($event->status === 'upcoming') bg-blue-100 text-blue-700
                            @elseif ($event->status === 'ongoing') bg-emerald-100 text-emerald-700
                            @else bg-rose-100 text-rose-700 @endif">
                                <i class="ri-time-line mr-1"></i> {{ ucfirst($event->status) }}
                            </span>
                        </div>

                        <p class="mt-2 text-xs text-gray-400 flex items-center">
                            <i class="ri-calendar-line mr-1"></i>
                            {{ $event->start_date }} → {{ $event->end_date }}
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="p-5 border-t border-gray-100 dark:border-gray-800 flex gap-3">
                        <a href="{{ route(Auth::user()->role === 'superadmin' ? 'superAdmin.events.dashboard' : 'admin.events.dashboard', $event->id) }}"
                            class="flex-1 text-center px-4 py-2 rounded-lg text-sm font-medium bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow hover:shadow-md hover:scale-[1.02] transition">
                            <i class="ri-settings-3-line mr-1"></i> Manage
                        </a>
                        <form action="{{ route('events.delete', $event->id) }}"
                            method="POST" class="flex-1 ajax-form"
                            data-success="Event deleted successfully"
                            data-confirm="Are you sure you want to delete this event?">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full px-4 py-2 text-sm font-medium rounded-lg border border-red-500 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition cursor-pointer">
                                <i class="ri-delete-bin-line mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    document.querySelectorAll('form[id^="delete-event-"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This action will permanently delete the product and all related data, including order items and attendees associated with it. Are you sure you want to proceed?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(form);
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const actionUrl = form.getAttribute('action');

                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin mr-2"></i> Deleting...';

                    fetch(actionUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]')
                                    .value,
                            },
                        }).then(async (res) => {
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
                                    html: (data.errors || [
                                        'Something went wrong'
                                    ]).join("<br>"),
                                    icon: 'error',
                                    confirmButtonColor: '#EF4444'
                                });
                            }
                        }).catch(() => {
                            Swal.fire({
                                title: 'Oops!',
                                text: 'Something went wrong',
                                icon: 'error',
                                confirmButtonColor: '#EF4444'
                            })
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                            submitBtn.innerHTML =
                                '<i class="ri-delete-bin-line mr-2"></i> Delete';
                        });
                }
            });
        });
    });
</script>
