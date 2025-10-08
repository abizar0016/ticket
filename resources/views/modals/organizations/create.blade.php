@if (!auth()->user()->organization)
    <div id="organizationModal" class="fixed inset-0 z-50 flex items-center justify-center">
    @else
        <div id="organizationModal" class="fixed inset-0 z-50 hidden items-center justify-center">
@endif

<!-- Backdrop -->
<div id="organizationModalBackdrop" class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity duration-300"></div>

<!-- Modal panel -->
<div id="organizationModalPanel"
    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">

    <!-- Header -->
    <div class="px-6 pt-6 pb-3 flex items-center gap-3">
        <div class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 shadow">
            <i class="ri-building-line text-lg"></i>
        </div>
        <div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Create Organization</h3>
            <p class="text-sm text-indigo-600 dark:text-indigo-400">Set up your organization profile</p>
        </div>
    </div>

    <!-- Body -->
    <form id="create-organization-form" action="{{ route('organizations.store') }}" class="ajax-form"
        data-success="Organization created successfully." method="POST" enctype="multipart/form-data">
        @csrf

        <div class="px-6 py-5 space-y-5">
            <div class="relative">
                <i class="ri-user-star-line absolute left-3 top-1/2 -translate-y-1/2 text-indigo-500 dark:text-indigo-400 text-lg"></i>
                <input type="text" id="organizationName" name="name"
                    class="w-full pl-11 pr-4 py-3 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm outline-none"
                    placeholder="Enter organization name" required>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 rounded-2xl flex justify-end bg-white dark:bg-gray-800">
            <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-medium hover:from-indigo-600 hover:to-indigo-700 transition flex items-center gap-2">
                <i class="ri-add-line"></i> Create
            </button>
        </div>
    </form>
</div>
</div>
