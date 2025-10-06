@extends('layouts.auth')

@section('content')
    <div class="w-full max-w-4xl animate__animated animate__fadeIn lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
        <!-- Left Side - Illustration -->
        <div class="hidden lg:flex flex-col items-center justify-center p-8">
            <div class="w-64 h-64 bg-indigo-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                <i class="ri-shield-user-line text-6xl text-indigo-600 dark:text-indigo-400"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 text-center mb-2">
                Welcome Back
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
                Sign in to access your account
            </p>
            <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                <li class="flex items-center"><i class="ri-check-line text-green-500 mr-2"></i> Access your
                    dashboard</li>
                <li class="flex items-center"><i class="ri-check-line text-green-500 mr-2"></i> Create your event
                    and tickets</li>
                <li class="flex items-center"><i class="ri-check-line text-green-500 mr-2"></i> Manage your event
                    and tickets</li>
            </ul>
        </div>

        <!-- Right Side - Form -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg">
            <div class="p-6 sm:p-8">
                <div class="lg:hidden text-center mb-6">
                    <div
                        class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <i class="ri-shield-user-line text-3xl"></i>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900">
                        Welcome back
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Sign in to your account
                    </p>
                </div>

                <form class="space-y-4" action="{{ route('login.store') }}" method="POST" autocomplete="on">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ri-mail-line text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" required
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 dark:border-gray-600 dark:text-gray-100 outline-none rounded-md py-2 border"
                                placeholder="your@email.com" autocomplete="email">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ri-lock-2-line text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-10 sm:text-sm border-gray-300 dark:border-gray-600 dark:text-gray-100 outline-none rounded-md py-2 border"
                                placeholder="••••••" autocomplete="current-password">
                            <!-- Tombol toggle -->
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i id="toggleIcon" class="ri-eye-off-line"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" autocomplete="on"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Remember me
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                                Forgot password?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center items-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300 cursor-pointer">
                            <i class="ri-login-box-line mr-2"></i>
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300">
                                Or sign in with
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 flex w-full">
                        <a href="{{ route('login.google') }}"
                            class="w-full inline-flex justify-center items-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="ri-google-fill text-red-500"></i>
                            <span class="ml-2">Google</span>
                        </a>
                    </div>
                </div>

                <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 hover:underline">
                        Register
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const passwordInput = document.querySelector("#password");
        const toggleIcon = document.querySelector("#toggleIcon");

        togglePassword.addEventListener("click", () => {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);

            // ganti ikon
            toggleIcon.classList.toggle("ri-eye-off-line");
            toggleIcon.classList.toggle("ri-eye-line");
        });
    </script>
@endsection
