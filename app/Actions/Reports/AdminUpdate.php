<?php

namespace App\Actions\Reports;

use App\Models\Report;
use Illuminate\Http\Request;

class AdminUpdate
{
    public function handle(Request $request, $id)
    {
        // ✅ Validasi input
        $validated = $request->validate([
            'admin_reply' => 'required|string|max:5000',
        ]);

        $report = Report::findOrFail($id);

        $report->update([
            'admin_reply' => $validated['admin_reply'],
            'admin_replied_at' => now(),
            'status' => 'replied',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Balasan admin berhasil dikirim.',
            'data' => $report,
        ]);
    }
}
