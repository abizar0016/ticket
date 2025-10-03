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

        if ($attendee->status === 'pending' && $attendee->order->status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket ini belum dibayar.'
            ], 403);
        }

        $product = $attendee->product;
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tiket tidak ditemukan.'
            ], 404);
        }

        $scanMode = strtolower($product->scan_mode ?? 'single');

        if ($scanMode === 'single') {
            if ($existing = Checkin::where('attendee_id', $attendee->id)->first()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sudah check-in sebelumnya pada ' . $existing->created_at->format('d/m/Y H:i'),
                    'previous_checkin' => $existing
                ], 409);
            }
        }

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
            'action'     => 'checkin',
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
