<?php

namespace App\Actions\Checkins;

use App\Models\{Attendee, Checkin, Activity};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProcessCheckin
{
public function handle(Request $request)
{
    try {
        $decryptedCode = (new DecryptTicketCode())->handle($request->ticket_code);
        Log::debug('Decrypted ticket code:', ['code' => $decryptedCode]);

        $attendee = Attendee::with(['event', 'order', 'product'])
            ->whereRaw('LOWER(TRIM(ticket_code)) = ?', [strtolower(trim($decryptedCode))])
            ->first();

        if (!$attendee) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak valid atau tidak ditemukan.'
            ], 404);
        }

        // 🚫 Jika order belum dibayar
        if ($attendee->status === 'pending' && $attendee->order->status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket ini belum dibayar.'
            ], 403);
        }

        // 🕒 Tambahkan kondisi expired di sini
        if ($attendee->order->status === 'expired') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket ini sudah kedaluwarsa dan tidak dapat digunakan.'
            ], 410);
        }

        $product = $attendee->product;
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tiket tidak ditemukan.'
            ], 404);
        }

        $scanMode = strtolower($product->scan_mode ?? 'single');

        // 🔄 Cek kalau tiket mode single dan sudah pernah check-in
        if ($scanMode === 'single') {
            if ($existing = Checkin::where('attendee_id', $attendee->id)->first()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sudah check-in sebelumnya pada ' . $existing->created_at->format('d/m/Y H:i'),
                    'previous_checkin' => $existing
                ], 409);
            }
        }

        // ✅ Buat record check-in baru
        $checkin = Checkin::create([
            'event_id'    => $attendee->event_id,
            'attendee_id' => $attendee->id,
            'product_id'  => $attendee->product_id,
            'order_id'    => $attendee->order_id,
            'ip_address'  => $request->ip(),
        ]);

        if ($scanMode === 'single') {
            $attendee->update(['status' => 'used']);
        }

        Activity::create([
            'user_id'    => Auth::id(),
            'action'     => 'Checkin',
            'model_type' => 'Checkin',
            'model_id'   => $checkin->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'attendee' => $attendee->fresh(),
            'event'    => $attendee->event,
            'checkin_time' => $checkin->created_at->format('d/m/Y H:i')
        ]);
    } catch (\Exception $e) {
        Log::error('Checkin error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

}
