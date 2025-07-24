@foreach ($attendees as $attendee)
    <div id="attendeesUpdateModal-{{ $attendee->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                    id="attendeesUpdateBackdrop-{{ $attendee->id }}">
                </div>
            </div>

            <!-- Modal Panel -->
            <div class="inline-block align-bottom bg-white rounded-4xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full opacity-0 translate-y-4 sm:scale-95"
                id="attendeesUpdatePanel-{{ $attendee->id }}" role="dialog" aria-modal="true"
                aria-labelledby="modal-headline">

                <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-3 rounded-xl bg-gradient-to-tr from-purple-500 to-indigo-600 text-white shadow-lg">
                                <i class="ri-user-line text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900" id="modal-headline">Update Attendee</h3>
                                <p class="text-indigo-600/80 text-lg mt-1">Update attendee information</p>
                            </div>
                        </div>
                        <button id="closeAttendeesUpdateModal-{{ $attendee->id }}"
                            class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    <div class="mt-6">
                        <form id="update-attendee-form-{{ $attendee->id }}"
                            action="{{ route('attendees.update', $attendee->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 gap-6">
                                <!-- Name and Email Row -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Name -->
                                    <div class="relative group">
                                        <input type="text" id="attendeeName-{{ $attendee->id }}" name="name"
                                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                            placeholder=" " value="{{ old('name', $attendee->name) }}" required>
                                        <label for="attendeeName-{{ $attendee->id }}"
                                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                            Full Name
                                        </label>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                            <i class="ri-user-line text-2xl"></i>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="relative group">
                                        <input type="email" id="attendeeEmail-{{ $attendee->id }}" name="email"
                                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                            placeholder=" " value="{{ old('email', $attendee->email) }}" required>
                                        <label for="attendeeEmail-{{ $attendee->id }}"
                                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                            Email Address
                                        </label>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                            <i class="ri-mail-line text-2xl"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ticket Code and Status Row -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Ticket Code -->
                                    <div class="relative group">
                                        <input type="text" id="attendeeTicketCode-{{ $attendee->id }}"
                                            name="ticket_code"
                                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                            placeholder=" " value="{{ old('ticket_code', $attendee->ticket_code) }}">
                                        <label for="attendeeTicketCode-{{ $attendee->id }}"
                                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                            Ticket Code
                                        </label>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                            <i class="ri-ticket-2-line text-2xl"></i>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="relative group">
                                        <select id="attendeeStatus-{{ $attendee->id }}" name="status"
                                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer appearance-none"
                                            required>
                                            <option value="active"
                                                {{ $attendee->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="pending"
                                                {{ $attendee->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        </select>
                                        <label for="attendeeStatus-{{ $attendee->id }}"
                                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                            Status
                                        </label>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                            <i class="ri-flag-line text-2xl"></i>
                                        </div>
                                        <div
                                            class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-gray-400">
                                            <i class="ri-arrow-down-s-line text-2xl"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Reference -->
                                <div class="relative group">
                                    <input type="text" id="attendeeOrder-{{ $attendee->id }}" name="order"
                                        readonly
                                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-gray-100 text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                                        placeholder=" " value="{{ old('order', $attendee->order->name) }}">
                                    <label for="attendeeOrder-{{ $attendee->id }}"
                                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                                        Order Reference
                                    </label>
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                                        <i class="ri-shopping-bag-line text-2xl"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl mt-6">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-lg font-medium hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                                    <i class="ri-save-line mr-2"></i> Update
                                </button>
                                <button type="button" id="cancelAttendeesUpdateModal-{{ $attendee->id }}"
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
@endforeach

<script>
    document.querySelectorAll('form[id^="update-attendee-form-"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');

            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

            fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                    }
                })
                .then(async (res) => {
                    const data = await res.json();

                    if (res.ok && data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#6366F1'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Oops!',
                            html: (data.errors || ['Something went wrong']).join(
                                "<br>"),
                            icon: 'error',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Something went wrong',
                        icon: 'error',
                        confirmButtonColor: '#EF4444'
                    });
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML = '<i class="ri-save-line mr-2"></i> Update';
                });
        });
    });
</script>
