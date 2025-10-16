<?php

namespace App\Actions\Reports;

use App\Mail\NewReportNotification;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StoreReport
{
    /**
     * Handle storing a new report for an event.
     */
    public function handle(Request $request, $id)
    {
        Log::info("🟡 StoreReport started for event_id={$id}, user_id=".Auth::id());

        try {
            // ✅ Validasi input
            $validated = $request->validate([
                'reason' => 'required|string',
                'description' => 'required|string',
            ]);
            Log::info('✅ Validation passed', $validated);
        } catch (\Throwable $e) {
            Log::error('❌ Validation failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: '.$e->getMessage(),
            ], 422);
        }

        // ✅ Cegah spam
        try {
            $existing = Report::where('user_id', Auth::id())
                ->where('event_id', $id)
                ->whereNull('admin_reply')
                ->first();

            if ($existing) {
                Log::warning('⚠️ Duplicate report detected for user_id='.Auth::id());

                return response()->json([
                    'success' => false,
                    'message' => 'Kamu sudah mengirim laporan untuk event ini. Harap tunggu tanggapan admin.',
                ], 422);
            }
        } catch (\Throwable $e) {
            Log::error('❌ Failed checking existing report: '.$e->getMessage());
        }

        // ✅ Simpan laporan
        try {
            $report = Report::create([
                'user_id' => Auth::id(),
                'event_id' => $id,
                'reason' => $request->reason,
                'description' => $request->description,
                'status' => 'unread',
            ]);
            Log::info("✅ Report created successfully, report_id={$report->id}");
        } catch (\Throwable $e) {
            Log::error('❌ Failed creating report: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan laporan.',
            ], 500);
        }

        // ✅ Kirim email ke admin
        try {
            // Ambil event dari relasi
            $event = $report->event;

            if ($event && $event->user && $event->user->email) {
                Log::info("📨 Sending report notification to event owner: {$event->user->email}");

                Mail::to($event->user->email)->send(new NewReportNotification($report));

                Log::info("✅ Email sent successfully to event owner: {$event->user->email}");
            } else {
                Log::warning("⚠️ Event owner email not found for event_id={$report->event_id}");
            }
        } catch (\Throwable $e) {
            Log::error("❌ Failed sending email to event owner for event_id={$report->event_id}: ".$e->getMessage());
        }

        Log::info("✅ StoreReport completed for report_id={$report->id}");

        // ✅ Response
        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim.',
            'data' => $report,
        ], 201);
    }
}
