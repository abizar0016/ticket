<?php

namespace App\Actions\Products;

use App\Models\Activity;
use App\Models\Event;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreProduct
{
    public function handle(Request $request, $eventId)
    {
        $validated = $request->validate([
            'type' => 'required|in:ticket,merchandise',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'scan_mode' => 'nullable|in:single,multi',
            'min_per_order' => 'nullable|integer|min:1',
            'max_per_order' => 'nullable|integer|min:1',
            'sale_start_date' => 'required|date',
            'sale_end_date' => 'nullable|date|after_or_equal:sale_start_date',
            'image' => 'nullable|image|max:5120',
        ]);

        if (Auth::user()->role === 'superadmin') {
            $event = Event::findOrFail($eventId);
        } else {
            $event = Event::where('id', $eventId)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        }

        $validated['event_id'] = $event->id;

        if ($request->hasFile('image')) {
            $publicPath = public_path('product_images');
            if (! file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }

            $imageName = time().'_'.Str::random(10).'.'.
                $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($publicPath, $imageName);
            $validated['image'] = 'product_images/'.$imageName;
        }

        $product = Product::create($validated);

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'create product',
            'model_type' => 'Product',
            'model_id' => $product->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully!',
            'product_id' => $product->id,
        ]);
    }
}
