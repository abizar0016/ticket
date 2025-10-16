@switch($activeContent)
    @case('dashboard')
        @include('pages.superAdmin.dashboard.index')
    @break

    @case('events')
        @include('pages.superAdmin.events.index')
    @break

    @case('events-content')
        @switch($eventsContent)
            @case('dashboard')
                @include('pages.events.dashboard')
            @break

            @case('settings')
                @include('pages.events.settings')
            @break

            @case('attendees')
                @include('pages.events.attendees')
            @break

            @case('orders')
                @include('pages.events.orders')
            @break

            @case('orders-show')
                @include('pages.events.order-show')
            @break

            @case('products')
                @include('pages.events.products')
            @break

            @case('checkins')
                @include('pages.events.checkins')
            @break

            @case('promos')
                @include('pages.events.promos')
            @break

            @case('reports')
                @include('pages.events.reports')
            @break

            @default
                @include('pages.events.dashboard')
        @endswitch
    @break

    @case('categories')
        @include('pages.superAdmin.categories.index')
    @break

    @case('orders')
        @include('pages.superAdmin.orders.index')
    @break

    @case('revenue-reports')
        @include('pages.superAdmin.orders.revenue-reports')
    @break

    @case('users')
        @include('pages.superAdmin.users.index')
    @break

    @case('organizations')
        @include('pages.superAdmin.users.organizations')
    @break

    @case('customers-reports')
        @include('pages.superAdmin.customers-reports.index')
    @break

    @case('reports-show')
        @include('pages.superAdmin.customers-reports.show')
    @break

    @case('activity')
        @include('pages.superAdmin.activity.index')
    @break

    @default
        @include('pages.superAdmin.dashboard.index')
@endswitch
