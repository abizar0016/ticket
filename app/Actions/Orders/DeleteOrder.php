<?php

namespace App\Actions\Orders;

use App\Models\Order;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteOrder
{
    public function handle(int $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        DB::transaction(function () use ($order) {
            $order->attendees()->delete();
            $order->items()->delete();
            $order->delete();
        });

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'delete order',
            'model_type' => 'Order',
            'model_id' => $order->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.'
        ]);
    }
}
