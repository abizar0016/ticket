<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto space-y-10">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 dark:border-gray-700 pb-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Detail Laporan #{{ $report->id }}
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Dibuat pada {{ $report->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            <a href="{{ route('superAdmin.customers-reports') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 
                       rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
        </div>

        <!-- Informasi Utama -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 space-y-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-3">
                Informasi Utama
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">User</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100 mt-1">
                        {{ $report->user->name ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Event</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100 mt-1">
                        {{ $report->event->title ?? 'Tidak ada event' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                    @php
                        $statusColors = [
                            'unread' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                            'read' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
                            'resolved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                            'escalated' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            'replied' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                            'dismissed' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                        ];
                    @endphp
                    <span
                        class="inline-block mt-2 px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                        {{ ucfirst($report->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Terakhir Diperbarui</p>
                    <p class="text-gray-700 dark:text-gray-300 mt-1">
                        {{ $report->updated_at->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Reason & Description -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 space-y-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Alasan</h3>
                <p class="mt-2 text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                    {{ $report->reason ?? '-' }}
                </p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Deskripsi</h3>
                <p class="mt-2 text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line">
                    {{ $report->description ?? '-' }}
                </p>
            </div>
        </div>

        <!-- Balasan Section -->
        <div class="space-y-8">

            @if ($report->admin_reply)
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl shadow-sm p-6">
                    <h3 class="text-base font-semibold text-blue-700 dark:text-blue-300 flex items-center gap-2 mb-2">
                        <i class="ri-user-2-line text-lg"></i> Balasan Admin
                    </h3>
                    <p class="text-sm text-gray-800 dark:text-gray-100 whitespace-pre-line">
                        {{ $report->admin_reply }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        Dibalas pada: {{ $report->admin_replied_at?->format('d M Y, H:i') ?? '-' }}
                    </p>
                </div>
            @else
                <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-base font-semibold text-blue-600 dark:text-blue-400 flex items-center gap-2 mb-2">
                        <i class="ri-user-2-line text-lg"></i> Balasan Admin
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 italic">Belum ada balasan dari admin.</p>
                </div>
            @endif

            @if ($report->super_admin_reply)
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl shadow-sm p-6">
                    <h3 class="text-base font-semibold text-green-700 dark:text-green-300 flex items-center gap-2 mb-2">
                        <i class="ri-shield-user-line text-lg"></i> Balasan Super Admin
                    </h3>
                    <p class="text-sm text-gray-800 dark:text-gray-100 whitespace-pre-line">
                        {{ $report->super_admin_reply }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        Dibalas pada: {{ $report->super_admin_replied_at?->format('d M Y, H:i') ?? '-' }}
                    </p>
                </div>
            @endif
        </div>

        <!-- Form Balasan / Edit -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ $report->admin_reply ? 'Edit Balasan Admin' : 'Kirim Balasan' }}
            </h3>
            <form method="POST" action="{{ route('admin.reports.reply', $report->id) }}" class="ajax-form space-y-5">
                @csrf
                @method('POST')

                <div>
                    <textarea name="admin_reply" rows="5" required
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                           bg-white dark:bg-gray-900 dark:text-gray-200 text-sm px-3 py-2 
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                        placeholder="Tulis tanggapan Anda di sini...">{{ old('admin_reply', $report->admin_reply) }}</textarea>
                    @error('admin_reply')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold 
                           rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition">
                        <i class="ri-send-plane-line"></i> 
                        {{ $report->admin_reply ? 'Update Balasan' : 'Kirim Balasan' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
