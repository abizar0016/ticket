@foreach ($attendees as $attendee)
<div id="attendeesUpdateModal-{{ $attendee->id }}"
    class="fixed inset-0 z-50 hidden flex justify-center items-center overflow-y-auto">
    
    <!-- Backdrop -->
    <div id="attendeesUpdateBackdrop-{{ $attendee->id }}"
    class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity duration-300"></div>

    <!-- Modal Panel -->
    <div class="relative rounded-2xl overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl w-full 
                bg-white dark:bg-gray-800/90 border border-gray-200 dark:border-gray-700 
                backdrop-blur-md scale-95 opacity-0"
        id="attendeesUpdatePanel-{{ $attendee->id }}" role="dialog" aria-modal="true">

        <!-- Header -->
        <div class="flex items-start justify-between p-6 border-b border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div
                    class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-md dark:shadow-indigo-900/20">
                    <i class="ri-user-line text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Update Attendee</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 text-lg mt-1">Update attendee information</p>
                </div>
            </div>
        </div>

        <form id="update-attendee-form-{{ $attendee->id }}"
            class="ajax-form p-6 space-y-6"
            action="{{ route('attendees.update', $attendee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Grid Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                        <i class="ri-user-line text-xl"></i>
                    </div>
                    <input type="text" name="name"
                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600
                               bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400/40
                               transition-all duration-300 peer outline-none"
                        placeholder=" " value="{{ old('name', $attendee->name) }}" required>
                    <label
                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-300 text-base transition-all duration-300 transform 
                               -translate-y-9 scale-90 bg-white dark:bg-gray-800 
                               peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                               peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                        Full Name
                    </label>
                </div>

                <!-- Email -->
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                        <i class="ri-mail-line text-xl"></i>
                    </div>
                    <input type="email" name="email"
                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600
                               bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400/40
                               transition-all duration-300 peer outline-none"
                        placeholder=" " value="{{ old('email', $attendee->email) }}" required>
                    <label
                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-300 text-base transition-all duration-300 transform 
                               -translate-y-9 scale-90 bg-white dark:bg-gray-800 
                               peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                               peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                        Email Address
                    </label>
                </div>
            </div>

            <!-- Other fields (same style as above) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ticket Code -->
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                        <i class="ri-ticket-2-line text-xl"></i>
                    </div>
                    <input type="text" name="ticket_code"
                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600
                               bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400/40
                               transition-all duration-300 peer outline-none"
                        placeholder=" " value="{{ old('ticket_code', $attendee->ticket_code) }}">
                    <label
                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-300 text-base transition-all duration-300 transform 
                               -translate-y-9 scale-90 bg-white dark:bg-gray-800 
                               peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                               peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                        Ticket Code
                    </label>
                </div>

                <!-- Status -->
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-indigo-500 dark:text-indigo-400">
                        <i class="ri-flag-line text-xl"></i>
                    </div>
                    <select name="status"
                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600
                               bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400/40
                               transition-all duration-300 outline-none appearance-none">
                        <option value="active" {{ $attendee->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="used" {{ $attendee->status == 'used' ? 'selected' : '' }}>Used</option>
                        <option value="pending" {{ $attendee->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 dark:text-gray-500">
                        <i class="ri-arrow-down-s-line text-xl"></i>
                    </div>
                    <label
                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-300 text-base transition-all duration-300 transform 
                               -translate-y-9 scale-90 bg-white dark:bg-gray-800 
                               peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                               peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                        Status
                    </label>
                </div>
            </div>

            <!-- Footer -->
            <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" id="cancelAttendeesUpdateModal-{{ $attendee->id }}"
                    class="px-6 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 
                           font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300">
                    <i class="ri-close-line mr-2"></i>Cancel
                </button>

                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 
                           text-white font-semibold shadow-md hover:shadow-lg 
                           hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300">
                    <i class="ri-save-line mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach
