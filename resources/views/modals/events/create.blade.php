<div id="eventModal" class="fixed flex justify-center items-center inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div id="modalBackdrop"
                class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
        </div>

        <!-- Modal Panel -->
        <div id="modalPanel"
            class="rounded-2xl overflow-hidden shadow-xl transform transition-all sm:max-w-2xl w-full opacity-0 translate-y-4 scale-95">
            <div
                class="bg-white dark:bg-gray-800 px-8 pt-8 pb-6 sm:p-8 sm:pb-6 max-h-[90vh] overflow-y-auto border border-gray-100 dark:border-gray-700">

                <!-- Header -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-start gap-4">
                        <div
                            class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
                            <i class="ri-calendar-event-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create New Event</h3>
                            <p class="text-indigo-600 dark:text-indigo-400 text-lg mt-1">Let’s create something amazing!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form id="create-event-form" action="{{ route('events.store') }}" class="ajax-form"
                    data-success="Event created successfully." method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-8">

                        <!-- Organization + Title -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Organization -->
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-community-line text-xl"></i>
                                </div>
                                <input type="text" id="eventOrganization" name="organization_id"
                                    value="{{ $organization->name ?? '' }}" readonly
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100 cursor-not-allowed shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 outline-none"
                                    placeholder=" ">
                                <label for="eventOrganization"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                    Organization
                                </label>
                            </div>

                            <!-- Title -->
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-edit-box-line text-xl"></i>
                                </div>
                                <input type="text" id="eventTitle" name="title"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none"
                                    placeholder=" " required>
                                <label for="eventTitle"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                    Event Title
                                </label>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-5 flex items-start pt-4 pointer-events-none text-indigo-500 dark:text-indigo-400">
                                <i class="ri-align-left text-xl"></i>
                            </div>
                            <textarea id="eventDescription" name="description" rows="3"
                                class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none resize-y min-h-[120px]"
                                placeholder=" " required></textarea>
                            <label for="eventDescription"
                                class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                Description
                            </label>
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-calendar-2-line text-xl"></i>
                                </div>
                                <input type="datetime-local" id="startDate" name="start_date"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none"
                                    placeholder=" " required>
                                <label for="startDate"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                    Start Date
                                </label>
                            </div>

                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-calendar-check-line text-xl"></i>
                                </div>
                                <input type="datetime-local" id="endDate" name="end_date"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none"
                                    placeholder=" " required>
                                <label for="endDate"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                    End Date
                                </label>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div>
                            <label
                                class="block text-gray-500 dark:text-gray-400 text-base font-medium mb-3">Category</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach ($categories as $category)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="categories_id" value="{{ $category->id }}"
                                            class="hidden peer" required>
                                        <span
                                            class="px-4 py-2 rounded-full border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 text-sm font-medium transition-all duration-300 outline-none 
                      peer-checked:bg-gradient-to-r peer-checked:from-indigo-500 peer-checked:to-indigo-600 peer-checked:text-white peer-checked:border-indigo-600
                      hover:bg-indigo-50 dark:hover:bg-indigo-600/30 hover:border-indigo-300">
                                            {{ $category->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Pick one category for your event.
                            </p>
                        </div>

                        <!-- Image Upload -->
                        <div class="relative">
                            <label class="block text-gray-500 dark:text-gray-400 text-base font-medium mb-2">
                                Event Image
                            </label>
                            <div id="upload-container" class="group">
                                <!-- Default -->
                                <div id="default-state"
                                    class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center cursor-pointer transition-all duration-300 outline-none hover:border-indigo-400 hover:bg-indigo-50/30 dark:hover:bg-indigo-600/20">
                                    <i
                                        class="ri-upload-cloud-2-line text-4xl text-indigo-500 dark:text-indigo-400 mb-3"></i>
                                    <p class="font-semibold text-gray-600 dark:text-gray-300">Upload Event Image</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF up to 10MB
                                    </p>
                                </div>

                                <!-- Preview -->
                                <div id="preview-state"
                                    class="hidden relative w-full h-64 rounded-xl overflow-hidden border-2 border-white dark:border-gray-700 shadow">
                                    <img id="preview-image" class="w-full h-full object-cover" src=""
                                        alt="Image Preview">
                                    <div
                                        class="absolute inset-0 bg-black/0 hover:bg-black/40 transition-all duration-300 outline-none flex items-center justify-center opacity-0 hover:opacity-100">
                                        <button type="button" id="change-image"
                                            class="bg-white text-indigo-600 px-4 py-2 rounded-lg shadow font-medium hover:bg-indigo-50 dark:bg-gray-900 dark:text-indigo-400 dark:hover:bg-gray-800">
                                            Change Image
                                        </button>
                                    </div>
                                </div>

                                <input id="file-upload" type="file" name="event_image" accept="image/*"
                                    class="hidden">
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div
                        class="bg-white dark:bg-gray-800 py-5 sm:flex sm:justify-end rounded-b-2xl mt-8">
                        <button type="button" id="cancelEventModal"
                            class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto transition-all duration-300 cursor-pointer">
                            <i class="ri-close-line mr-2"></i> Cancel
                        </button>
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                            <i class="ri-add-line mr-2"></i> Create Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
