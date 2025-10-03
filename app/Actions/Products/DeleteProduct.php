<?php

namespace App\Actions\Products;

use App\Models\Activity;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteProduct
{
    public function handle(int $productId)
    {
        $product = Product::findOrFail($productId);

        if (Auth::user()->role !== 'superadmin' && Auth::id() !== $product->event->user_id) {
            abort(403, 'Unauthorized');
        }

        DB::transaction(function () use ($product) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            foreach ($product->orderItems as $item) {
                $order = $item->order;
                $item->delete();

                if ($order->items()->count() === 0) {
                    $order->attendees()->delete();
                    $order->delete();
                }
            }

            $product->delete();

            Activity::create([
                'user_id' => Auth::id(),
                'action' => 'delete product',
                'model_type' => 'Product',
                'model_id' => $product->id,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Product and all related data deleted.',
        ]);
    }
}
