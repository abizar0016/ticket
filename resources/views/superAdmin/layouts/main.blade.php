<main class="p-6">
    @switch($activeContent)
        @case('dashboard')
            @include('superAdmin.dashboard.index')
            @break

        @case('allEvents')
            @include('superAdmin.events.index')
            @break

        @case('events')
            @switch($eventsContent)
                @case('dashboard')
                    @include('superAdmin.events.dashboard')
                @break
                @case('settings')
                    @include('superAdmin.events.settings')
                @break
            @endswitch
            @break

        @default
            @include('superAdmin.dashboard.index')
    @endswitch
</main>
