<div id="eventModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                id="modalBackdrop"></div>
        </div>

        <!-- Modal Panel -->
        <<div
            class="inline-block bg-white rounded-4xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 align-middle max-w-2xl w-full opacity-0 translate-y-4 scale-95"
            id="modalPanel">
            <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4 max-h-[90vh] overflow-y-auto">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <div
                            class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
                            <i class="ri-calendar-event-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Create New Event</h3>
                            <p class="text-indigo-600/80 text-lg mt-1">Let's create something amazing!</p>
                        </div>
                    </div>
                    <button id="closeEventModal"
                        class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <div class="mt-6">
                    <form id="create-event-form" action="{{ route('event.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Event Organization -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div class="relative group">
                                    <select id="eventOrganizer" name="organization_id"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer">
                                        @foreach ($organizations as $organization)
                                            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="eventOrganizer"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                        Event Organization
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-community-line text-2xl"></i>
                                    </div>
                                </div>

                                <!-- Title Input with Floating Label -->
                                <div class="relative group">
                                    <input type="text" id="eventTitle" name="title"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
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
                                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 resize-y min-h-[100px] hover:min-h-[120px] focus:min-h-[120px] peer"
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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Start Date -->
                                <div class="relative group">
                                    <input type="datetime-local" id="startDate" name="start_date"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
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

                                <!-- End Date -->
                                <div class="relative group">
                                    <input type="datetime-local" id="endDate" name="end_date"
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
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

                            <!-- Image Upload -->
                            <div class="relative group">
                                <div id="upload-container">
                                    <!-- Default State -->
                                    <div id="default-state"
                                        class=" flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                        <i class="ri-upload-cloud-2-line text-4xl text-indigo-500"></i>
                                        <p class="font-semibold text-gray-700">Upload Event Image</p>
                                        <p class="text-sm text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>

                                    <!-- Preview State -->
                                    <div id="preview-state"
                                        class="hidden relative w-full h-auto rounded-lg overflow-hidden">
                                        <img id="preview-image" class="w-full object-cover" src=""
                                            alt="Image Preview">
                                        <button type="button" id="change-image"
                                            class="absolute top-2 right-2 bg-white/70 hover:bg-white text-sm px-3 py-1 rounded-md shadow">Change
                                        </button>
                                    </div>

                                    <input id="file-upload" type="file" name="event_image" accept="image/*"
                                        class="hidden">
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl mt-6">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-lg font-medium hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
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
    document.getElementById('create-event-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');

        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Creating...';

        fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async (res) => {
                const data = await res.json();

                if (res.ok && data.success) {
                    // Tampilkan alert lalu redirect jika user klik OK
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#6366F1'
                    }).then(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.reload();
                        }
                    });
                } else {
                    const errorMessages = [];

                    if (Array.isArray(data.errors)) {
                        errorMessages.push(...data.errors);
                    } else if (typeof data.errors === 'object') {
                        for (const key in data.errors) {
                            if (Array.isArray(data.errors[key])) {
                                errorMessages.push(...data.errors[key]);
                            } else {
                                errorMessages.push(data.errors[key]);
                            }
                        }
                    }

                    Swal.fire({
                        title: 'Oops!',
                        html: errorMessages.length > 0 ? errorMessages.join("<br>") :
                            'Something went wrong.',
                        icon: 'error',
                        confirmButtonColor: '#EF4444'
                    });
                }
            })
            .catch((error) => {
                console.error('Network or Server Error:', error);
                Swal.fire({
                    title: 'Oops!',
                    text: 'Something went wrong (network or server error)',
                    icon: 'error',
                    confirmButtonColor: '#EF4444'
                });
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                submitBtn.innerHTML = '<i class="ri-add-line mr-2"></i> Create Event';
            });
    });
</script>
