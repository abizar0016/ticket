<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900">
                Explore Events
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                Manage all events
            </p>
        </div>
    </div>


    @include('components.filters')
    @include('components.card.event')

