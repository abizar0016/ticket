<?php

namespace App\Actions\Orders;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class MarkAsPaid
{
public function handle(int $id): JsonResponse
{
    $order = Order::with(['items.product', 'attendees'])->findOrFail($id);

    if ($order->status !== 'pending') {
        return response()->json([
            'success' => false,
            'message' => 'Order is not in pending status.',
        ], 400);
    }

    foreach ($order->items as $item) {
        if ($item->product->quantity !== null) {
            $item->product->decrement('quantity', $item->quantity);
        }
    }

    // Update attendee status
    foreach ($order->attendees as $attendee) {
        $attendee->update(['status' => 'active']);
    }

    // Update order status
    $order->update(['status' => 'paid']);

    // Pesan konfirmasi
    $message = "Halo, pesanan Anda dengan ID #{$order->id} telah dikonfirmasi.";

    // 1. Kirim ke order sendiri
    if ($order->email) {
        Mail::raw($message, function($mail) use ($order) {
            $mail->to($order->email)
                 ->subject('Konfirmasi Pesanan Anda');
        });
    }

    if ($order->phone) {
        $whatsappLink = 'https://wa.me/' . $order->phone . '?text=' . urlencode($message);
    }

    // 2. Kirim ke semua attendee
    foreach ($order->attendees as $attendee) {
        $messageAttendee = "Halo {$attendee->name}, pesanan Anda dengan ID #{$order->id} telah dikonfirmasi.";

        if ($attendee->email) {
            Mail::raw($messageAttendee, function($mail) use ($attendee) {
                $mail->to($attendee->email)
                     ->subject('Konfirmasi Pesanan Anda');
            });
        }

        if ($attendee->phone) {
            $whatsappLink = 'https://wa.me/' . $attendee->phone . '?text=' . urlencode($messageAttendee);
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Order marked as paid and notifications sent.',
    ]);
}
}
