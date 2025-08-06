<div class="relative overflow-hidden">
    <!-- Floating gradient background elements -->
    <div
        class="absolute -top-20 -right-20 w-96 h-96 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-full blur-3xl -z-10 motion-safe:animate-[float_8s_ease-in-out_infinite]">
    </div>
    <div
        class="absolute -bottom-10 -left-10 w-80 h-80 bg-gradient-to-br from-blue-500/10 to-cyan-500/10 rounded-full blur-3xl -z-10 motion-safe:animate-[float-delay_10s_ease-in-out_infinite]">
    </div>

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
                    @switch($currentFilter)
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
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mb-8">
            @foreach ($events as $event)
                @php
                    $eventStatus = 'Draft';
                    $statusColors = [
                        'Draft' => 'bg-gradient-to-r from-amber-400 to-amber-500',
                        'Ended' => 'bg-gradient-to-r from-rose-500 to-rose-600',
                        'Ongoing' => 'bg-gradient-to-r from-emerald-400 to-emerald-600',
                        'Upcoming' => 'bg-gradient-to-r from-blue-400 to-blue-600',
                    ];

                    $statusIcons = [
                        'Draft' => 'ri-draft-line',
                        'Ended' => 'ri-checkbox-circle-line',
                        'Ongoing' => 'ri-flashlight-line',
                        'Upcoming' => 'ri-time-line',
                    ];

                    if ($event->status === 'published') {
                        if ($event->start_date > $now) {
                            $eventStatus = 'Upcoming';
                        } elseif ($event->end_date && $event->end_date < $now) {
                            $eventStatus = 'Ended';
                        } else {
                            $eventStatus = 'Ongoing';
                        }
                    }
                @endphp

                <!-- Event Card -->
                <div class="relative group transition-all duration-500 hover:z-10">
                    <div class="relative h-full transition-transform duration-500 ease-out group-hover:-translate-y-2">
                        <div
                            class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg overflow-hidden border border-white/20 hover:shadow-xl transition-all duration-500 h-full flex flex-col animate-[fadeInUp_0.6s_ease-out_forwards]">
                            <!-- Image -->
                            <div class="relative h-56 overflow-hidden">
                                @if ($event->event_image)
                                    <div class="absolute inset-0 bg-gradient-to-b from-black/10 to-black/30 z-10"></div>
                                    <img src="{{ asset($event->event_image) }}" alt="{{ $event->name }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center">
                                        <i class="ri-calendar-event-line text-5xl text-gray-400"></i>
                                    </div>
                                @endif

                                <!-- Date Badge -->
                                <div
                                    class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2 shadow-lg border border-white/20 z-20">
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ $event->start_date->setTimezone($tz)->format('M j') }}
                                        @if ($event->end_date && !$event->start_date->isSameDay($event->end_date))
                                            <span class="font-normal">-
                                                {{ $event->end_date->setTimezone($tz)->format('M j') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="absolute top-4 right-4 flex items-center gap-2">
                                    <span
                                        class="{{ $statusColors[$eventStatus] }} text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md backdrop-blur-sm flex items-center gap-1">
                                        <i class="{{ $statusIcons[$eventStatus] }}"></i>
                                        {{ $eventStatus }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6 flex-grow flex flex-col">
                                <h3
                                    class="text-xl font-extrabold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors duration-300 line-clamp-2">
                                    {{ $event->title }}
                                </h3>

                                <p class="text-gray-600/90 mb-5 line-clamp-3 flex-grow">
                                    {{ Str::limit($event->description, 120) }}
                                </p>

                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                                            <i class="ri-user-line text-green-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ $attendeesCount[$event->id] ?? 0 }} attending
                                        </span>
                                    </div>
                                </div>

                                <!-- Manage + Delete Buttons -->
                                <div class="mt-auto pt-4 border-t border-gray-100/60 space-y-3">
                                    <!-- Manage -->
                                    <a href="{{ route('event.dashboard', $event->id) }}"
                                        class="relative flex items-center justify-between gap-3 w-full px-5 py-3 rounded-xl bg-white border border-gray-200 shadow-sm hover:shadow-xl group transition-all duration-300 overflow-hidden">
                                        <span
                                            class="relative z-10 font-semibold text-gray-700 group-hover:text-indigo-600 transition-colors">Manage
                                            Event</span>
                                        <span
                                            class="relative z-10 flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100 transition-all duration-300 shadow-md group-hover:shadow-lg">
                                            <i
                                                class="ri-arrow-right-line group-hover:translate-x-1 transition-transform duration-300 text-lg"></i>
                                        </span>
                                        <span
                                            class="absolute inset-0 bg-gradient-to-r from-indigo-50/60 to-indigo-100/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></span>
                                    </a>

                                    <!-- Delete -->
                                    <form id="delete-event-{{ $event->id }}"
                                        action="{{ route('event.delete', $event->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="relative flex items-center justify-between gap-3 w-full px-5 py-3 rounded-xl bg-white border border-red-100 shadow-sm hover:shadow-md group transition-all duration-300 overflow-hidden">
                                            <span
                                                class="relative z-10 font-semibold text-red-600 group-hover:text-red-700 transition-colors">Delete
                                                Event</span>
                                            <span
                                                class="relative z-10 flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 text-red-600 group-hover:bg-red-100 transition-all duration-300 shadow-md group-hover:shadow-lg">
                                                <i
                                                    class="ri-delete-bin-line group-hover:scale-110 transition-transform duration-300 text-lg"></i>
                                            </span>
                                            <span
                                                class="absolute inset-0 bg-gradient-to-r from-red-50/50 to-red-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Optional Shadow Layer -->
                        <div
                            class="absolute inset-0 rounded-2xl bg-black/5 blur-md -z-10 transition-all duration-500 group-hover:opacity-100 group-hover:-translate-y-1">
                        </div>
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
