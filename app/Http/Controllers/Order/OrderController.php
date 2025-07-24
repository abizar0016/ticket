<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function update(Request $request, $id)
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

        $order->update([
            'name' => $request->name,
            'email' => $request->email,
            'total_price' => $request->total_price,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        DB::transaction(function () use ($order) {
            $order->attendees()->delete();

            $order->items()->delete();

            $order->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.',
        ]);
    }
}