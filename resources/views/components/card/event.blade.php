<div class="relative overflow-hidden">
    @if ($events->isEmpty())
        <!-- Empty State -->
        <div
            class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-12 text-center animate-[fadeIn_0.6s_ease-out_forwards] overflow-hidden border border-white/20 dark:border-gray-700/20">
            <div class="relative z-10">
                <div
                    class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-400 dark:from-gray-600 dark:to-gray-800 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                    <i class="ri-calendar-2-line text-4xl"></i>
                </div>
                <h3
                    class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3 bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600 dark">
                    No events found</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto text-lg">
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
                            <span><i class="ri-folder-2-line mr-1"></i>Category:
                                {{ $event->categories->name ?? 'Uncategorized' }}</span>
                            <span><i class="ri-user-line mr-1"></i>Created By:
                                {{ $event->user->name ?? 'Unknown' }}</span>
                            <span><i class="ri-building-2-line mr-1"></i>Organization:
                                {{ $event->organization->name ?? 'No Organization' }}</span>
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
                    <div
                        class="p-5 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between gap-2">
                        <!-- Manage Button (utama) -->
                        <a href="{{ route(Auth::user()->role === 'superadmin' ? 'superAdmin.events.dashboard' : 'admin.events.dashboard', $event->id) }}"
                            class="flex-1 px-4 py-2 rounded-lg text-sm font-medium bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow hover:shadow-md hover:scale-[1.02] transition flex items-center justify-center gap-2">
                            <i class="ri-settings-3-line"></i>
                            Manage
                        </a>

                        <!-- Share Button (lebih ringan, elegan) -->
                        <button type="button"
                            onclick="navigator.share ? navigator.share({ title: '{{ $event->title }}', url: '{{ route('events.show', $event->id) }}' }) : copyToClipboard('{{ route('events.show', $event->id) }}')"
                            class="px-3 py-2 rounded-lg text-sm font-medium border border-indigo-200 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition flex items-center gap-1 cursor-pointer">
                            <i class="ri-share-forward-line"></i>
                            Share
                        </button>

                        <!-- Delete Button -->
                        <form action="{{ route('events.delete', $event->id) }}" method="POST" class="ajax-form"
                            data-success="Event deleted successfully"
                            data-confirm="Are you sure you want to delete this event?">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-2 text-sm font-medium rounded-lg border border-red-200 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition flex items-center gap-1 cursor-pointer">
                                <i class="ri-delete-bin-line"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
