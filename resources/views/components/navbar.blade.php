<nav class="sticky top-0 z-50 flex justify-between w-full bg-white dark:bg-gray-900 py-4 px-6 shadow-sm">
    <div class="flex items-center gap-4">
        {{-- Logo Section --}}
        <a href="{{ Auth::user()->role == 'superadmin' ? route('superAdmin.dashboard') : (Auth::user()->role == 'admin' ? route('admin.index') : route('home')) }}"
            class="flex items-center gap-3 transition-all duration-300 hover:scale-[1.02]">
            <div
                class="flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600">
                <i class="ri-dashboard-3-line text-2xl text-white"></i>
            </div>
            <span class="text-xl font-bold text-gray-800 dark:text-white hidden md:block">
                {{ env('APP_NAME') }}
            </span>
        </a>
    </div>

    <div class="flex items-center gap-4">
        {{-- Tampilkan toggle publish kalau ada $eventId --}}
        @if (isset($eventId))
            <div class="flex items-center space-x-3 bg-gray-100 dark:bg-gray-800 px-4 py-2 rounded-lg">
                <form id="publish-form-{{ $events->id }}" action="{{ route('events.togglePublish', $events->id) }}"
                    method="POST" class="flex items-center space-x-3">
                    @csrf
                    @method('PUT')

                    <span id="draft-label-{{ $events->id }}"
                        class="text-sm text-gray-700 dark:text-gray-200 mr-2 {{ $events->is_published ? '' : 'text-indigo-600 dark:text-indigo-400 font-medium' }}">
                        Draft
                    </span>

                    <label class="relative inline-flex items-center cursor-pointer mx-1">
                        <input type="checkbox" name="is_published" value="1" class="sr-only peer"
                            {{ $events->is_published ? 'checked' : '' }}>
                        <div
                            class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 dark:peer-focus:ring-indigo-400 rounded-full peer peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500 transition-colors duration-300">
                        </div>
                        <div
                            class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform transition-transform duration-300 peer-checked:translate-x-5">
                        </div>
                    </label>

                    <span id="published-label-{{ $events->id }}"
                        class="text-sm text-gray-700 dark:text-gray-200 ml-2 {{ $events->is_published ? 'text-indigo-600 dark:text-indigo-400 font-medium' : '' }}">
                        Published
                    </span>
                </form>
            </div>

            <script>
                const form = document.getElementById('publish-form-{{ $events->id }}');
                const checkbox = form.querySelector('input[name="is_published"]');
                const draftLabel = document.getElementById('draft-label-{{ $events->id }}');
                const publishedLabel = document.getElementById('published-label-{{ $events->id }}');

                checkbox.addEventListener('change', function() {
                    const isChecked = this.checked;

                    // Tambahkan delay 1 detik sebelum fetch
                    setTimeout(() => {
                        const formData = new FormData(form);

                        fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Updated!',
                                        text: data.message,
                                        icon: 'success',
                                        timer: 1000,
                                        showConfirmButton: false
                                    });

                                    if (isChecked) {
                                        draftLabel.classList.remove('text-indigo-600', 'dark:text-indigo-400',
                                            'font-medium');
                                        publishedLabel.classList.add('text-indigo-600', 'dark:text-indigo-400',
                                            'font-medium');
                                    } else {
                                        draftLabel.classList.add('text-indigo-600', 'dark:text-indigo-400',
                                            'font-medium');
                                        publishedLabel.classList.remove('text-indigo-600',
                                            'dark:text-indigo-400', 'font-medium');
                                    }
                                } else {
                                    Swal.fire('Error!', data.message, 'error');
                                    checkbox.checked = !isChecked;
                                }
                            })

                            .catch(err => {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                                checkbox.checked = !isChecked;
                            });
                    });
                });
            </script>
        @endif
        @if (request()->routeIs(['home', 'events.show', 'checkout.form']))
            <a href="{{ route('orders.customers') }}"
                class="hidden md:flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <i class="ri-shopping-bag-line text-gray-600 dark:text-gray-100"></i>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-100">My Orders</span>
            </a>
        @endif

        {{-- Kalau superadmin tampilkan notifikasi --}}
        @if (request()->routeIs('superAdmin.dashboard'))
            <button
                class="relative h-10 w-10 flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ri-notification-3-line text-lg text-gray-600 dark:text-gray-300"></i>
                <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-orange-400"></span>
            </button>
        @endif

        {{-- User Profile Dropdown --}}
        <div class="relative">
            <button id="user-menu-button"
                class="flex items-center gap-2 pl-1 pr-2 py-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer">
                <div class="relative">
                    @if (!empty(Auth::user()->profile_picture))
                        <img src="{{ Auth::user()->profile_picture }}" alt="{{ Auth::user()->name }}"
                            class="w-9 h-9 rounded-full border-2 border-white shadow-sm object-cover">
                    @else
                        <div
                            class="w-9 h-9 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500 flex items-center justify-center text-white font-medium text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                            {{ substr(strstr(Auth::user()->name, ' '), 1, 1) ?? '' }}
                        </div>
                    @endif
                </div>
                <span class="hidden md:inline-block font-medium text-sm text-gray-700 dark:text-gray-100">
                    {{ Auth::user()->name }}
                </span>
                <i class="ri-arrow-down-s-line text-gray-500"></i>
            </button>

            {{-- Dropdown --}}
            <div id="user-menu"
                class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl ring-1 ring-gray-200 dark:ring-gray-700 overflow-hidden z-50 transition-all duration-200 origin-top-right scale-95 opacity-0">
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</p>
                </div>

                @if (in_array(Auth::user()->role, ['customer', 'admin', 'superadmin']))
                    <a href="{{ route('orders.customers') }}"
                        class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 md:hidden">
                        <i class="ri-shopping-bag-line mr-3 text-indigo-500"></i> My Orders
                    </a>
                @endif

                <a href="{{ route('logout') }}"
                    class="flex items-center gap-2 px-4 py-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-700/30 rounded-lg transition">
                    <i class="ri-logout-circle-r-line"></i> Logout
                </a>
            </div>

        </div>
    </div>
</nav>
