<?php

namespace App\Actions\Orders;

use App\Models\Order;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UpdateOrder
{
    public function handle(Request $request, int $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'total_price' => 'required|numeric',
            'status' => 'required|in:pending,paid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $order->update($validator->validated());

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'update order',
            'model_type' => 'Order',
            'model_id' => $order->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully.'
        ]);
    }
}
