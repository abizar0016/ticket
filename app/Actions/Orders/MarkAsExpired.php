<?php

namespace App\Actions\Orders;

use App\Models\Order;
use Illuminate\Http\JsonResponse;

class MarkAsExpired
{
    public function handle(int $id): JsonResponse
    {
        $order = Order::with(['items.product', 'attendees'])->findOrFail($id);

        if ($order->status === 'expired') {
            return response()->json([
                'success' => false,
                'message' => 'Order is already expired.',
            ], 400);
        }

        foreach ($order->attendees as $attendee) {
            $attendee->update(['status' => 'expired']);
        }

        $order->update(['status' => 'expired']);

        return response()->json([
            'success' => true,
            'message' => 'Order marked as expired.',
        ]);
    }
}
