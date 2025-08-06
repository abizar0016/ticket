<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ env('APP_NAME') }} |
        {{ ucwords(str_replace(['.', '_'], ' ', request()->route()->getName())) }}
    </title>
    <meta name="description" content="Modern admin dashboard template built with Tailwind CSS">

    <!-- Favicon -->
    <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- QR Scanner -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>


    {{-- JS --}}
    <script>
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/userTimezone.js') }}"></script>

    <!-- Vite CSS -->
    @vite('resources/css/app.css')

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        /* Smooth transitions */
        .transition-smooth {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Navbar shadow when scrolled */
        .scrolled-nav {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        #upload-container {
            transition: all 0.2s ease;
        }

        #upload-container:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
        }

        #upload-container.drag-over {
            border-color: #3b82f6;
            background-color: #eff6ff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
