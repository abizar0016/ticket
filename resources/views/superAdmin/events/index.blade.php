<h1 class="text-2xl font-bold mb-6">All Events</h1>

@if ($events->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($events as $event)
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-800 overflow-hidden">

                <!-- Event Image -->
                <div class="h-40 w-full bg-gray-200 dark:bg-gray-800">
                    @if ($event->event_image)
                        <img src="{{ asset($event->event_image) }}" alt="{{ $event->title }}"
                            class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-gray-400 text-sm">No Image</div>
                    @endif
                </div>

                <!-- Event Details -->
                <div class="p-5">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 line-clamp-2">{{ $event->title }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ $event->category->name ?? 'Uncategorized' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        By {{ $event->user->name ?? 'Unknown' }}
                    </p>

                    <div class="mt-3">
                        <span
                            class="px-2 py-1 text-xs rounded-lg 
                                @if ($event->status === 'draft') bg-gradient-to-r from-amber-400 to-amber-500 text-white
                                @else bg-gradient-to-r from-emerald-400 to-emerald-600 text-white @endif">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        {{ $event->start_date }} → {{ $event->end_date }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="p-5 flex justify-between items-center border-t border-gray-100 dark:border-gray-800">
                    <a href="{{ route('superAdmin.events.dashboard', $event->id) }}"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                        Manage
                    </a>
                    <form action="" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this event?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-gray-800 rounded-lg transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
@else
    <div class="text-center text-gray-500 dark:text-gray-400 py-10">
        No events found.
    </div>
@endif
