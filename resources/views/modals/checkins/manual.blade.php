{{-- Manual Check-in Modal --}}
<div id="manualCheckinModal" class="fixed flex justify-center items-center inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center sm:block sm:p-0">
        {{-- Backdrop --}}
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div id="manualCheckinBackdrop"
                class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300">
            </div>
        </div>

        {{-- Modal Panel --}}
        <div id="manualCheckinPanel"
            class="rounded-2xl overflow-hidden shadow-xl transform transition-all sm:max-w-md w-full opacity-0 translate-y-4 scale-95"
            role="dialog" aria-modal="true" aria-labelledby="manual-checkin-headline">

            <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4 sm:p-6">
                {{-- Header --}}
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-start gap-4">
                        <div
                            class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg dark:shadow-indigo-900/20">
                            <i class="ri-keyboard-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 id="manual-checkin-headline"
                                class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Manual Check-in
                            </h3>
                            <p class="text-indigo-600 dark:text-indigo-400 text-lg mt-1">
                                Masukkan kode tiket secara manual
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Body --}}
                <form id="manualCheckinForm" action="{{ route('checkins.manual') }}" class="ajax-form"
                    data-success="Manual check-in berhasil." method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        {{-- Ticket Code --}}
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                <i class="ri-keyboard-line text-xl"></i>
                            </div>
                            <input type="text" name="ticket_code" id="ticket_code"
                                class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 
                                focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 
                                bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 
                                transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none"
                                placeholder=" " required>
                            <label for="ticket_code"
                                class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base 
                                transition-all duration-300 transform -translate-y-9 scale-90 
                                bg-white dark:bg-gray-700 rounded 
                                peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                                peer-focus:-translate-y-9 peer-focus:scale-90 
                                peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                Kode Tiket
                            </label>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div
                        class="bg-white dark:bg-gray-800 py-4 sm:flex sm:justify-end rounded-b-xl mt-6">
                        <button type="button" id="cancelManualCheckin"
                            class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 dark:border-gray-600 
                            shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-semibold text-gray-700 dark:text-gray-200 
                            hover:bg-gray-50 dark:hover:bg-gray-800 hover:-translate-y-0.5 
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                            sm:mt-0 sm:ml-3 sm:w-auto transition-all duration-300 cursor-pointer">
                            <i class="ri-close-line mr-2"></i> Batal
                        </button>

                        <button type="submit"
                            class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 
                            bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold 
                            hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 
                            focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto 
                            transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                            <i class="ri-add-line mr-2"></i> Check-in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
