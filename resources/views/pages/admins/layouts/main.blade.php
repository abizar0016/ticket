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

    @case('reports-show')
        @include('pages.events.reports-show')
    @break

    @default
        @include('pages.events.dashboard')
@endswitch
