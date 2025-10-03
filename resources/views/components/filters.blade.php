<div
    class="border flex flex-col p-5 rounded-2xl 
            bg-white/70 dark:bg-gray-900/70 backdrop-blur-md 
            shadow-sm text-indigo-600 dark:text-indigo-100 mb-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">

        {{-- Left side: Status + Category --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">

            {{-- Status Buttons --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route(
                    Auth::user()->role === 'superadmin' ? 'superAdmin.events' : 'admin.index',
                    array_merge(request()->except('page'), [
                        'category' => request('category'),
                        'search' => request('search'),
                    ]),
                ) }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl 
        transition {{ $eventStatus === null ? $allClass : $defaultClass }}">
                    <i class="ri-list-unordered mr-2"></i> All
                </a>

                @foreach ($statusColors as $status => $activeClass)
                    <a href="{{ route(
                        Auth::user()->role === 'superadmin' ? 'superAdmin.events.status' : 'admin.events.status',
                        array_merge(['status' => $status], request()->except('page')),
                    ) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl 
            transition {{ $eventStatus === $status ? $activeClass : $defaultClass }}">
                        <i class="ri-checkbox-blank-circle-fill mr-2"></i> {{ ucfirst($status) }}
                    </a>
                @endforeach
            </div>

            {{-- Category Dropdown --}}
            <form method="GET"
                action="{{ $eventStatus
                    ? route(Auth::user()->role === 'superadmin' ? 'superAdmin.events.status' : 'admin.events.status', [
                        'status' => $eventStatus,
                    ])
                    : route(Auth::user()->role === 'superadmin' ? 'superAdmin.events' : 'admin.index') }}">
                <div class="relative w-full sm:w-48">
                    <select name="category" id="categories" onchange="this.form.submit()"
                        class="block w-full px-4 py-2 pr-10 text-sm font-medium rounded-xl 
                   bg-gray-100 dark:bg-gray-800 border border-gray-300 
                   text-gray-700 dark:text-gray-200 shadow-sm 
                   focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer appearance-none">
                        <option value="all" {{ $selectedCategory == 'all' || !$selectedCategory ? 'selected' : '' }}>
                            All Categories
                        </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                </div>

                @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
            </form>

        </div>

        {{-- Right side: Search --}}
        <div class="relative w-full sm:w-64">
            <form method="GET"
                action="{{ $eventStatus ? route('superAdmin.events.status', ['status' => $eventStatus]) : route('superAdmin.events') }}"
                class="relative transition-all hover:-translate-y-0.5">

                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="ri-search-line"></i>
                </div>
                <input type="search" name="search"
                    class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 
                           dark:border-gray-600 bg-gray-100 dark:bg-gray-800 
                           text-sm placeholder-gray-400 text-gray-800 dark:text-gray-200
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 
                           transition-all duration-200 hover:shadow-sm"
                    placeholder="Search events by name..." value="{{ $search }}">
            </form>
        </div>
    </div>
</div>
