<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ env('APP_NAME') }} |
        {{ ucwords(str_replace(['.', '_'], ' ', request()->route()->getName())) }}
    </title>
    <meta name="description" content="Modern admin dashboard template built with Tailwind CSS">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- QR Scanner -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- JS --}}
    <script>
        window.csrfToken = "{{ csrf_token() }}";
    </script>

    <script src="{{ asset('js/superAdmin/chart.js') }}"></script>
    <script src="{{ asset('js/swall.js') }}"></script>

    @vite(['resources/css/app.css'])

</head>

<body class="bg-gray-50 text-gray-900">

    {{-- Preloader --}}
    @include('components.preloader')

    {{-- Navbar --}}
    @if (Auth::check())
        @include('components.navbar')
    @else
        <nav class="fixed top-0 w-full flex justify-end px-4 py-2 bg-white/60 sm:px-6 sm:py-4 z-50">
            <div class="flex gap-3">
                <a href="{{ route('login') }}"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 border border-gray-800 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-100 transition">
                    Register
                </a>
            </div>
        </nav>
    @endif


    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    @vite(['resources/js/app.js', 'resources/js/superAdmin/index.js'])
</body>

</html>
