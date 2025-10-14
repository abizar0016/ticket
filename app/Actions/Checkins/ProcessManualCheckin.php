<?php

namespace App\Actions\Checkins;

use App\Models\{Attendee, Checkin, Activity};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProcessManualCheckin
{
    public function handle(Request $request)
    {
        try {
            $attendee = Attendee::with(['event', 'order', 'product'])
                ->whereRaw('LOWER(TRIM(ticket_code)) = ?', [strtolower(trim($request->ticket_code))])
                ->firstOrFail();

            if ($attendee->status === 'pending' && $attendee->order->status !== 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket belum dibayar.',
                    'manual_checkin' => true
                ], 403);
            }

            if ($existing = Checkin::where('attendee_id', $attendee->id)->first()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sudah check-in sebelumnya pada ' . $existing->created_at->format('d/m/Y H:i'),
                    'manual_checkin' => true
                ], 409);
            }

            $checkin = Checkin::create([
                'event_id'    => $attendee->event_id,
                'attendee_id' => $attendee->id,
                'product_id'  => $attendee->product_id,
                'order_id'    => $attendee->order_id,
                'ip_address'  => $request->ip(),
            ]);

            $attendee->update(['status' => 'used']);

            Activity::create([
                'user_id'    => Auth::id(),
                'action'     => 'Checkin',
                'model_type' => 'Checkin',
                'model_id'   => $checkin->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-in manual berhasil!',
                'attendee' => $attendee->load('event', 'order', 'product'),
                'event'    => $attendee->event,
                'checkin_time' => $checkin->created_at->format('d/m/Y H:i'),
                'manual_checkin' => true
            ]);
        } catch (\Exception $e) {
            $statusCode = $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500;
            $message = $statusCode === 404 ? 'Tiket tidak valid.' : $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $message,
                'manual_checkin' => true
            ], $statusCode);
        }
    }
}
