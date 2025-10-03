<?php

namespace App\Actions\Orders;

use App\Models\Order;
use Illuminate\Http\JsonResponse;

class MarkAsPending
{
    public function handle(int $id): JsonResponse
    {
        $order = Order::with(['items.product', 'attendees'])->findOrFail($id);

        if ($order->status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Order is not in paid status.',
            ], 400);
        }

        foreach ($order->items as $item) {
            if ($item->product->quantity !== null) {
                $item->product->increment('quantity', $item->quantity);
            }
        }

        foreach ($order->attendees as $attendee) {
            $attendee->update(['status' => 'pending']);
        }

        $order->update(['status' => 'pending']);

        return response()->json([
            'success' => true,
            'message' => 'Order marked as pending.',
        ]);
    }
}
