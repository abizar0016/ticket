<?php

namespace App\Actions\Reports;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SuperAdminUpdate
{
    public function handle(Request $request, $id)
    {
        // ✅ Validasi input
        $validated = $request->validate([
            'super_admin_reply' => 'nullable|string|max:5000',
            'status' => 'required|string|in:replied,resolved,escalated,dismissed',
        ]);

        // ✅ Ambil laporan
        $report = Report::findOrFail($id);

        // ✅ Update data laporan
        $report->update([
            'super_admin_reply' => $validated['super_admin_reply'],
            'super_admin_replied_at' => $validated['super_admin_reply'] ? now() : $report->super_admin_replied_at,
            'status' => $validated['status'],
        ]);

        // ✅ (Opsional) Log aktivitas
        Log::info('Super admin updated report', [
            'report_id' => $report->id,
            'status' => $validated['status'],
            'super_admin' => auth()->user()->id ?? 'system',
        ]);

        // ✅ Balikan response AJAX
        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil diperbarui oleh Super Admin.',
            'data' => $report,
        ]);
    }
}
