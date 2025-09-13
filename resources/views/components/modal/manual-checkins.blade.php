<!-- Manual Check-In Modal -->
<form action="{{ route('manual.checkin') }}" method="POST" id="manual-checkin-form">
    @csrf
    <div id="manual-checkin-modal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-xl md:rounded-2xl overflow-hidden w-full max-w-md transform transition-all">
            <div class="p-4 sm:p-6">
                <div class="flex items-start gap-3 sm:gap-4">
                    <div class="flex-shrink-0 p-2 sm:p-3 rounded-md sm:rounded-lg bg-indigo-100 text-indigo-600">
                        <i class="ri-keyboard-line text-lg sm:text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1 sm:mb-2">Manual Check-In</h3>
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">Enter ticket code or attendee details
                        </p>

                        <div class="space-y-3 sm:space-y-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Ticket
                                    Code</label>
                                <input type="text" name="ticket_code"
                                    class="w-full px-3 sm:px-4 py-2 border border-gray-200 rounded-lg md:rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-xs sm:text-sm"
                                    placeholder="ABC123XYZ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 flex justify-end gap-2 sm:gap-3">
                <button id="cancel-manual-checkin" type="button"
                    class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-semibold text-gray-700 hover:bg-gray-50 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto transition-all duration-300 cursor-pointer">
                    Cancel
                </button>
                <button type="submit"
                    class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                    Check In
                </button>
            </div>
        </div>
    </div>
</form>
