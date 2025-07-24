<!doctype html>
<html lang="en">

@include('components.head.head')
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .sidebar-divider {
        @apply w-full h-px bg-gray-200 my-4;
    }

    .card-gradient-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card-gradient-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

  ard-gradient-3 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .card-gradient-4 {
        background: linear-gradient(135deg, #00c6ff, #0072ff 100%);
    }
</style>


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
                        @include('eventDashboard.page.dashboard')
                    @break

                    @case('settings')
                        @include('eventDashboard.page.settings')
                    @break

                    @case('attendees')
                        @include('eventDashboard.page.attendees')
                    @break

                    @case('orders')
                        @include('eventDashboard.page.orders')
                    @break

                    @case('ticket-products')
                        @include('eventDashboard.page.ticket-merchandise')
                    @break

                    @case('checkins')
                        @include('eventDashboard.page.checkins')
                    @break

                    @case('promo-codes')
                        @include('eventDashboard.page.promo-codes')
                    @break

                    @default
                        @include('eventDashboard.page.dashboard')
                @endswitch
            </main>
        </div>
    </div>

</body>

</html>
