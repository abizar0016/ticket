<!-- resources/views/layouts/auth.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ env('APP_NAME') }} |
        {{ ucwords(str_replace(['.', '_'], ' ', request()->route()->getName())) }}
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>

<body class="font-inter bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-900">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
</body>

</html>
