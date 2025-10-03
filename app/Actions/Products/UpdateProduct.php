<?php

namespace App\Actions\Products;

use App\Models\Activity;
use App\Models\Event;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UpdateProduct
{
    public function handle(Request $request, int $productId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'min_per_order' => 'nullable|integer|min:1',
            'max_per_order' => 'nullable|integer|min:1',
            'sale_start_date' => 'required|date',
            'sale_end_date' => 'nullable|date|after_or_equal:sale_start_date',
            'image' => 'nullable|image|max:5120',
        ]);

        $product = Product::findOrFail($productId);

        if (Auth::user()->role === 'superadmin') {
            $event = Event::findOrFail($product->event_id);
        } else {
            $event = Event::where('id', $product->event_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        }

        $validated['event_id'] = $event->id;

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $publicPath = public_path('product_images');
            if (! file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }

            $imageName = time().'_'.Str::random(10).'.'.
                $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($publicPath, $imageName);
            $validated['image'] = 'product_images/'.$imageName;
        }

        $product->update($validated);

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'update product',
            'model_type' => 'Product',
            'model_id' => $product->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully!',
        ]);
    }
}
