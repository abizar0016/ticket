<div id="eventModal" class="fixed flex justify-center items-center inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center sm:block sm:p-0">

        <!-- Backdrop -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div id="modalBackdrop"
                class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
        </div>

        <!-- Modal Panel -->
        <div id="modalPanel"
                class="bg-white rounded-2xl overflow-hidden shadow-xl transform transition-all sm:max-w-2xl w-full opacity-0 translate-y-4 scale-95">
            <div class="bg-white px-8 pt-8 pb-6 sm:p-8 sm:pb-6 max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <div
                            class="p-4 rounded-2xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-md">
                            <i class="ri-calendar-event-line text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-3xl font-extrabold text-gray-900">Create New Event</h3>
                            <p class="text-indigo-600/80 text-lg mt-1">Let’s create something amazing!</p>
                        </div>
                    </div>
                    <button id="closeEventModal"
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                        <i class="ri-close-line text-3xl"></i>
                    </button>
                </div>

                <!-- Form -->
                <div class="mt-8">
                    <form id="create-event-form" action="{{ route('events.store') }}" class="ajax-form"
                        data-success="Event created successfully." method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-8">

                            <!-- Organization + Title -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Organization -->
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-community-line text-2xl"></i>
                                    </div>
                                    <input type="text" id="eventOrganization" name="organization_id"
                                        value="{{ $organization->name ?? '' }}" readonly
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 bg-gray-100 text-gray-800 transition-all duration-300 shadow-sm peer cursor-not-allowed"
                                        placeholder=" ">
                                    <label for="eventOrganization"
                                        class="absolute left-14 top-4 px-1 text-gray-500 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 font-medium">
                                        Organization
                                    </label>
                                </div>

                                <!-- Title -->
                                <div class="relative group">
                                    <input type="text" id="eventTitle" name="title"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 bg-white text-gray-800 transition-all duration-300 shadow-sm peer"
                                        placeholder=" " required>
                                    <label for="eventTitle"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                        Event Title
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-edit-box-line text-2xl"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="relative group">
                                <textarea id="eventDescription" name="description" rows="3"
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 bg-white text-gray-800 transition-all duration-300 shadow-sm resize-y min-h-[120px] peer"
                                    placeholder=" " required></textarea>
                                <label for="eventDescription"
                                    class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                    Description
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-start pt-4 pointer-events-none text-indigo-500">
                                    <i class="ri-align-left text-2xl"></i>
                                </div>
                            </div>

                            <!-- Date Range -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Start -->
                                <div class="relative group">
                                    <input type="datetime-local" id="startDate" name="start_date"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 bg-white text-gray-800 transition-all duration-300 peer"
                                        placeholder=" " required>
                                    <label for="startDate"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                        Start Date
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-calendar-2-line text-2xl"></i>
                                    </div>
                                </div>

                                <!-- End -->
                                <div class="relative group">
                                    <input type="datetime-local" id="endDate" name="end_date"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-500 bg-white text-gray-800 transition-all duration-300 peer"
                                        placeholder=" " required>
                                    <label for="endDate"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                        End Date
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-calendar-check-line text-2xl"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Categories -->
                            <div>
                                <label class="block text-gray-700 text-base font-medium mb-3">Category</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($categories as $category)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="categories_id" value="{{ $category->id }}"
                                                class="hidden peer" required>
                                            <span
                                                class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 bg-gray-100 text-sm font-medium transition-all duration-300 
                    peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600
                    hover:bg-indigo-50 hover:border-indigo-400 hover:text-indigo-600">
                                                {{ $category->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Pick one category for your event.</p>
                            </div>


                            <!-- Image Upload -->
                            <div class="relative">
                                <label class="block text-gray-700 text-base font-medium mb-2">Event Image</label>
                                <div id="upload-container" class="group">
                                    <!-- Default -->
                                    <div id="default-state"
                                        class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer transition-all duration-300 group-hover:border-indigo-400 group-hover:bg-indigo-50/30">
                                        <i class="ri-upload-cloud-2-line text-4xl text-indigo-500 mb-3"></i>
                                        <p class="font-semibold text-gray-700">Upload Event Image</p>
                                        <p class="text-sm text-gray-500 mt-1">PNG, JPG, GIF up to 10MB</p>
                                    </div>

                                    <!-- Preview -->
                                    <div id="preview-state"
                                        class="hidden relative w-full h-64 rounded-xl overflow-hidden border-2 border-gray-200">
                                        <img id="preview-image" class="w-full h-full object-cover" src=""
                                            alt="Image Preview">
                                        <div
                                            class="absolute inset-0 bg-black/0 hover:bg-black/30 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                            <button type="button" id="change-image"
                                                class="bg-white text-indigo-600 px-4 py-2 rounded-lg shadow-md font-medium hover:bg-indigo-50 transition-colors cursor-pointer">
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
                        <div class="bg-gray-50 px-8 py-5 sm:flex sm:flex-row-reverse rounded-b-2xl mt-8">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-lg font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                <i class="ri-add-line mr-2"></i> Create Event
                            </button>
                            <button type="button" id="cancelEventModal"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-lg font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300">
                                <i class="ri-close-line mr-2"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const selectedCategories = new Set();
const categoriesContainer = document.getElementById('categories-container');
const hiddenInput = document.getElementById('selectedCategories');

if (categoriesContainer && hiddenInput) {
    categoriesContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('category-pill')) {
            const id = e.target.dataset.id;

            if (selectedCategories.has(id)) {
                selectedCategories.delete(id);
                e.target.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                e.target.classList.add('bg-gray-100', 'text-gray-700', 'border');
            } else {
                selectedCategories.add(id);
                e.target.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                e.target.classList.remove('bg-gray-100', 'text-gray-700', 'border');
            }

            hiddenInput.value = Array.from(selectedCategories).join(',');
        }
    });
}
</script>
