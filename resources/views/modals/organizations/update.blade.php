@foreach ($organizations as $organization)
    <div id="organizationUpdateModal-{{ $organization->id }}"
        class="fixed inset-0 z-50 hidden flex items-center justify-center backdrop-blur-sm">
        <!-- Backdrop -->
        <div id="organizationUpdateBackdrop-{{ $organization->id }}"
            class="absolute inset-0 bg-gray-900/70 opacity-0 transition-opacity duration-300"></div>

        <!-- Modal Panel -->
        <div id="organizationUpdatePanel-{{ $organization->id }}"
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl mx-4 opacity-0 scale-95 translate-y-6 transition-all duration-300 overflow-hidden">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg shadow-indigo-500/20">
                        <i class="ri-building-line text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Update Organization</h3>
                        <p class="text-sm text-indigo-600 dark:text-indigo-400">Edit organization details</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <form action="{{ route('organizations.update', $organization->id) }}" class="ajax-form"
                data-success="Organization updated successfully." method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-6 py-6 space-y-5">
                    <!-- Organization Name -->
                    <div class="relative">
                        <i
                            class="ri-user-star-line absolute left-3 top-1/2 -translate-y-1/2 text-indigo-500 dark:text-indigo-400 text-lg"></i>
                        <input type="text" id="organizationName" name="name"
                            class="w-full pl-11 pr-4 py-3 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm outline-none"
                            placeholder="Enter organization name" required value="{{ $organization->name }}">
                    </div>

                    <!-- Owner Info -->
                    <div class="relative">
                        <i
                            class="ri-user-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-lg"></i>
                        <input type="text" id="organizationOwner" name="created_by"
                            value="{{ $organization->user->name ?? 'Unknown User' }}" readonly
                            class="w-full pl-11 pr-4 py-3 border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700/60 text-gray-500 dark:text-gray-400 rounded-xl text-sm outline-none cursor-not-allowed"
                            placeholder="Created by">
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-gray-800/60">
                    <button type="button" id="cancelUpdateOrganizationModal-{{ $organization->id }}"
                        class="inline-flex justify-center items-center px-5 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                        <i class="ri-close-line mr-2"></i> Cancel
                    </button>   
                    <button type="submit"
                        class="inline-flex justify-center items-center px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-sm font-semibold shadow hover:from-indigo-600 hover:to-indigo-700 transition-all">
                        <i class="ri-check-line mr-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endforeach
