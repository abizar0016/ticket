@foreach ($attendees as $attendee)
    <div id="attendeesUpdateModal-{{ $attendee->id }}" class="fixed flex justify-center items-center inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center sm:block sm:p-0">

            <!-- Backdrop -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                    id="attendeesUpdateBackdrop-{{ $attendee->id }}">
                </div>
            </div>

            <!-- Modal Panel -->
            <div class="rounded-2xl overflow-hidden shadow-xl transform transition-all sm:max-w-2xl w-full opacity-0 translate-y-4 scale-95"
                id="attendeesUpdatePanel-{{ $attendee->id }}" role="dialog" aria-modal="true"
                aria-labelledby="modal-headline">

                <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4 sm:p-6">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
                                <i class="ri-user-line text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100" id="modal-headline">Update Attendee</h3>
                                <p class="text-indigo-600 dark:text-indigo-400 text-lg mt-1">Update attendee information</p>
                            </div>
                        </div>
                        <button id="closeAttendeesUpdateModal-{{ $attendee->id }}"
                            class="text-gray-400 hover:text-indigo-500 transition-colors duration-200 cursor-pointer">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    <form id="update-attendee-form-{{ $attendee->id }}"
                        class="ajax-form"
                        action="{{ route('attendees.update', $attendee->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name and Email Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-400">
                                        <i class="ri-user-line text-xl"></i>
                                    </div>
                                    <input type="text" id="attendeeName-{{ $attendee->id }}" name="name"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none"
                                        placeholder=" " value="{{ old('name', $attendee->name) }}" required>
                                    <label for="attendeeName-{{ $attendee->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-200 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                        Full Name
                                    </label>
                                </div>

                                <!-- Email -->
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-mail-line text-xl"></i>
                                    </div>
                                    <input type="email" id="attendeeEmail-{{ $attendee->id }}" name="email"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none"
                                        placeholder=" " value="{{ old('email', $attendee->email) }}" required>
                                    <label for="attendeeEmail-{{ $attendee->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-200 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                        Email Address
                                    </label>
                                </div>
                            </div>

                            <!-- Ticket Code and Status Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Ticket Code -->
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-ticket-2-line text-xl"></i>
                                    </div>
                                    <input type="text" id="attendeeTicketCode-{{ $attendee->id }}"
                                        name="ticket_code"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none"
                                        placeholder=" " value="{{ old('ticket_code', $attendee->ticket_code) }}">
                                    <label for="attendeeTicketCode-{{ $attendee->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-200 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                        Ticket Code
                                    </label>
                                </div>

                                <!-- Status -->
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                        <i class="ri-flag-line text-xl"></i>
                                    </div>
                                    <select id="attendeeStatus-{{ $attendee->id }}" name="status"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none appearance-none"
                                        required>
                                        <option value="active"
                                            {{ $attendee->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="used" {{ $attendee->status == 'used' ? 'selected' : '' }}>
                                            Used</option>
                                        <option value="pending"
                                            {{ $attendee->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                    <label for="attendeeStatus-{{ $attendee->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-200 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                        Status
                                    </label>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                        <i class="ri-arrow-down-s-line text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Reference -->
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                                    <i class="ri-shopping-bag-line text-xl"></i>
                                </div>
                                <input type="text" id="attendeeOrder-{{ $attendee->id }}" name="order"
                                    readonly
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none cursor-not-allowed"
                                    placeholder=" " value="{{ old('order', $attendee->order->name) }}">
                                <label for="attendeeOrder-{{ $attendee->id }}"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-200 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                    Order Reference
                                </label>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-gray-50 dark:bg-gray-800 px-1 py-4 sm:flex sm:flex-row-reverse rounded-b-xl mt-6">
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                                <i class="ri-save-line mr-2"></i> Update Attendee
                            </button>
                            <button type="button" id="cancelAttendeesUpdateModal-{{ $attendee->id }}"
                                class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto transition-all duration-300 cursor-pointer">
                                <i class="ri-close-line mr-2"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach