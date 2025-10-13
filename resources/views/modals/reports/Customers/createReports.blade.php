<div id="reportEventModal"
    class="fixed inset-0 z-50 hidden flex justify-center items-center overflow-y-auto">

    <!-- Backdrop -->
    <div id="reportEventBackdrop"
        class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity duration-300"></div>

    <!-- Modal Panel -->
    <div class="relative rounded-2xl overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl w-full 
                bg-white dark:bg-gray-800/90 border border-gray-200 dark:border-gray-700 
                backdrop-blur-md scale-95 opacity-0"
        id="reportEventPanel" role="dialog" aria-modal="true">

        <!-- Header -->
        <div class="flex items-start justify-between p-6 border-b border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div
                    class="p-3 rounded-xl bg-gradient-to-tr from-red-500 to-red-600 text-white shadow-md dark:shadow-red-900/20">
                    <i class="ri-flag-2-line text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Laporkan Event</h3>
                    <p class="text-red-600 dark:text-red-400 text-lg mt-1">Laporkan masalah pada event ini</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form id="report-event-form-{{ $event->id }}"
            class="ajax-form p-6 space-y-6"
            data-success="Laporan berhasil dikirim."
            action="" method="POST">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">

            <!-- Reason -->
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-red-500 dark:text-red-400">
                    <i class="ri-error-warning-line text-xl"></i>
                </div>
                <select name="reason"
                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600
                           bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                           focus:border-red-500 focus:ring-2 focus:ring-red-400/40
                           transition-all duration-300 outline-none appearance-none"
                    required>
                    <option value="">Pilih alasan laporan</option>
                    <option value="event_scam">Event Terindikasi Scam</option>
                    <option value="inappropriate_content">Konten Tidak Pantas</option>
                    <option value="false_information">Informasi Palsu</option>
                    <option value="payment_issue">Masalah Pembayaran</option>
                    <option value="other">Lainnya</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 dark:text-gray-500">
                    <i class="ri-arrow-down-s-line text-xl"></i>
                </div>
                <label
                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-300 text-base transition-all duration-300 transform 
                           -translate-y-9 scale-90 bg-white dark:bg-gray-800 
                           peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                           peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-red-600 dark:peer-focus:text-red-400 font-medium">
                    Alasan Laporan
                </label>
            </div>

            <!-- Description -->
            <div class="relative group">
                <div class="absolute top-5 left-0 pl-5 flex items-start text-red-500 dark:text-red-400">
                    <i class="ri-edit-2-line text-xl mt-1"></i>
                </div>
                <textarea name="description" rows="5"
                    class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600
                           bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                           focus:border-red-500 focus:ring-2 focus:ring-red-400/40
                           transition-all duration-300 outline-none resize-none"
                    placeholder="Jelaskan secara detail masalah atau keanehan yang kamu temukan..." required>{{ old('description') }}</textarea>
                <label
                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-300 text-base transition-all duration-300 transform 
                           -translate-y-9 scale-90 bg-white dark:bg-gray-800 
                           peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                           peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-red-600 dark:peer-focus:text-red-400 font-medium">
                    Deskripsi
                </label>
            </div>

            <!-- Footer -->
            <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" id="cancelReportEventModal"
                    class="px-6 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 
                           font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300">
                    <i class="ri-close-line mr-2"></i>Batal
                </button>

                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-500 to-red-600 
                           text-white font-semibold shadow-md hover:shadow-lg 
                           hover:from-red-600 hover:to-red-700 transition-all duration-300">
                    <i class="ri-flag-2-line mr-2"></i>Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>