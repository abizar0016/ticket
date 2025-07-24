<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ __('Register') }} | {{ env('APP_NAME') }} </title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .split-container {
            min-height: 0;
        }

        @media (min-width: 1024px) {
            .split-container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
                align-items: center;
            }

            .form-container {
                padding: 2rem 0;
            }
        }
    </style>
</head>

<body class="font-inter bg-gradient-to-br from-blue-50 to-indigo-100">
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-4xl animate__animated animate__fadeIn split-container">
            <!-- Left Side - Illustration -->
            <div class="hidden lg:flex flex-col items-center justify-center p-8">
                <div class="w-64 h-64 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-user-plus text-6xl text-indigo-600"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 text-center mb-2">
                    Join Our Community
                </h2>
                <p class="text-gray-600 text-center mb-6">
                    Create your account and unlock all features
                </p>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Access your
                        dashboard</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Create your
                        event and tikets</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Manage your
                        event and tickets</li>
                </ul>
            </div>

            <!-- Right Side - Form -->
            <div class="bg-white shadow-lg rounded-lg form-container">
                <div class="p-6 sm:p-8">
                    <div class="lg:hidden text-center mb-6">
                        <div
                            class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mb-4">
                            <i class="fas fa-user-plus text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-extrabold text-gray-900">
                            Create your account
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            Join our community today
                        </p>
                    </div>

                    <form class="space-y-4" action="{{ route('register.store') }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input id="name" name="name" type="text" required
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-2 border"
                                        placeholder="your name">
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input id="email" name="email" type="email" required
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-2 border"
                                        placeholder="your@email.com">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input id="password" name="password" type="password" required
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-2 border"
                                        placeholder="••••••">
                                </div>
                            </div>

                            <div>
                                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm
                                    Password</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input id="password-confirm" name="password_confirmation" type="password" required
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-2 border"
                                        placeholder="••••••">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input id="terms" name="terms" type="checkbox"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="terms" class="ml-2 block text-xs text-gray-700">
                                I agree to the <a href="#"
                                    class="font-medium text-indigo-600 hover:text-indigo-500">Terms</a> and <a
                                    href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Privacy
                                    Policy</a>
                            </label>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center items-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                                <i class="fas fa-user-plus mr-2"></i>
                                Create Account
                            </button>
                        </div>
                    </form>

                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">
                                    Or sign up with
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div>
                                <a href="{{ route('login.google') }}"
                                    class="w-full inline-flex justify-center items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <i class="fab fa-google text-red-500"></i>
                                    <span class="ml-2">Google</span>
                                </a>
                            </div>
                            <div>
                                <a href="#"
                                    class="w-full inline-flex justify-center items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <i class="fab fa-facebook-f text-blue-600"></i>
                                    <span class="ml-2">Facebook</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Sign in
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
