<!doctype html>
<html lang="en">

@include('components.head.head')


<body class="bg-gray-50  text-gray-800 ">
    <!-- Preloader -->
    @include('components.preloader.preloader')

    <div class="flex">
        <!-- Sidebar -->
        @include('components.sidebar.sidebar')

        <!-- Main Content -->
        <div class="flex-1 transition-all duration-300 md:ml-64" id="main-content">
            @include('components.navbar.navbar')

            <!-- Content -->
            <main class="p-6">
                @switch($activeContent)
                    @case('dashboard')
                        @include('Admin.eventDashboard.page.dashboard')
                    @break

                    @case('settings')
                        @include('Admin.eventDashboard.page.settings')
                    @break

                    @case('attendees')
                        @include('Admin.eventDashboard.page.attendees')
                    @break

                    @case('orders')
                        @include('Admin.eventDashboard.page.orders')
                    @break

                    @case('order-show')
                        @include('Admin.eventDashboard.order-show.index')
                    @break

                    @case('ticket-products')
                        @include('Admin.eventDashboard.page.ticket-merchandise')
                    @break

                    @case('checkins')
                        @include('Admin.eventDashboard.page.checkins')
                    @break

                    @case('promo-codes')
                        @include('Admin.eventDashboard.page.promo-codes')
                    @break

                    @default
                        @include('Admin.eventDashboard.page.dashboard')
                @endswitch
            </main>
        </div>
    </div>

</body>

</html>
