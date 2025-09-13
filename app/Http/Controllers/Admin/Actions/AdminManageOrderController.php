<?php

namespace App\Http\Controllers\Admin\Actions;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminManageOrderController extends Controller
{
    public function markAsPaid($id)
    {
        $order = Order::with(['items.product', 'attendees'])->findOrFail($id);

        Log::info("Mark as Paid called for Order ID: {$id}");

        if ($order->status === 'pending') {
            foreach ($order->items as $item) {
                Log::info("Decrementing stock for Product ID: {$item->product->id} by {$item->quantity}");
                $item->product->decrement('quantity', $item->quantity);
            }

            // Update status attendees ke active
            foreach ($order->attendees as $attendee) {
                Log::info("Activating attendee ID: {$attendee->id}");
                $attendee->update(['status' => 'active']);
            }

            $order->update(['status' => 'paid']);
            Log::info("Order ID: {$id} updated to 'paid'");
        } else {
            Log::warning("Order ID: {$id} is not in pending status (status: {$order->status})");
        }

        return response()->json([
            'success' => true,
            'message' => 'Order marked as paid.',
        ]);
    }

    public function markAsPending($id)
    {
        $order = Order::with(['items.product', 'attendees'])->findOrFail($id);

        Log::info("Mark as Pending called for Order ID: {$id}");

        if ($order->status === 'paid') {
            foreach ($order->items as $item) {
                Log::info("Incrementing stock for Product ID: {$item->product->id} by {$item->quantity}");
                $item->product->increment('quantity', $item->quantity);
            }

            // Update status attendees ke inactive
            foreach ($order->attendees as $attendee) {
                Log::info("Deactivating attendee ID: {$attendee->id}");
                $attendee->update(['status' => 'pending']);
            }

            $order->update(['status' => 'pending']);
            Log::info("Order ID: {$id} updated to 'pending'");
        } else {
            Log::warning("Order ID: {$id} is not in paid status (status: {$order->status})");
        }

        return response()->json([
            'success' => true,
            'message' => 'Order marked as pending.',
        ]);
    }


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
