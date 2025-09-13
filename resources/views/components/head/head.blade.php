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
    <script src="{{ asset('js/userTimezone.js') }}"></script>

    <script src="{{ asset('js/superAdmin/chart.js') }}"></script>

    @vite(['resources/css/app.css', 'resources/js/superAdmin/index.js', 'resources/js/app.js'])

</head>
