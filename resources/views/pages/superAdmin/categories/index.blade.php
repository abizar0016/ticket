<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
            <div class="flex flex-col gap-2">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                    Explore Categories
                </h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl">
                    Temukan event atau produk sesuai kategori favoritmu.
                </p>
            </div>

            <div class="relative">
                <button id="openModalAddCategory"
                    class="inline-flex items-center gap-2 text-white bg-gradient-to-r from-indigo-500 to-indigo-600 
                       hover:from-indigo-600 hover:to-indigo-700 focus:ring-4 focus:outline-none 
                       focus:ring-indigo-300 font-medium rounded-xl text-sm px-5 py-3 
                       shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 w-full sm:w-auto justify-center cursor-pointer">
                    <i class="ri-add-line text-lg"></i>
                    <span>Tambah</span>
                </button>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
            @foreach ($categories as $category)
                <a href="{{ route('superAdmin.events', ['category' => $category->id]) }}"
                    class="group relative block rounded-2xl overflow-hidden bg-white dark:bg-gray-800 
                       shadow-md hover:shadow-xl transition-all duration-300 
                       border border-gray-200 dark:border-gray-700 hover:-translate-y-1">
                    <!-- Hover overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 dark:from-indigo-300/20 dark:to-pink-300/20 to-pink-500/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>

                    <!-- Content -->
                    <div class="p-6 sm:p-8 relative z-10 flex flex-col items-center text-center">
                        <div
                            class="mb-4 w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center 
                               rounded-xl bg-indigo-100 dark:bg-indigo-500/50
                               text-indigo-600 dark:text-indigo-300 
                               text-2xl sm:text-3xl font-bold">
                            {{ strtoupper(substr($category->name, 0, 1)) }}
                        </div>
                        <h3
                            class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100 
                               group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ $category->name }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

@include('pages.superAdmin.categories.partials.add-modal')

<script src="{{ asset('js/superAdmin/modal.js') }}"></script>
