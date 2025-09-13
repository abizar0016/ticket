<?php

namespace App\Http\Controllers\Admin\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class AdminManageProductController extends Controller
{
    public function store(Request $request, $id)
    {
        $event = Event::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:ticket,merchandise',
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $createData = $validator->validated();
        $createData['event_id'] = $event->id;

        if ($request->hasFile('image')) {
            $publicPath = public_path('product_images');
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }

            $imageName = time() . '_' . Str::random(10) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($publicPath, $imageName);
            $createData['image'] = 'product_images/' . $imageName;
        }

        try {
            $product = new Product($createData);
            $product->save();

            Log::info('✅ Product saved:', ['id' => $product->id, 'title' => $product->title]);
        } catch (\Exception $e) {
            Log::error('❌ Failed to save product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'errors' => ['Server error: ' . $e->getMessage()]
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully!'
        ]);
    }
    public function update(Request $request, $id)
    {
        Log::info('Update request received', [
            'product_id' => $id,
            'all_input' => $request->all()
        ]);

        // Cari produk berdasarkan ID & pastikan user pemilik event-nya
        $item = Product::where('id', $id)->firstOrFail();
        $event = Event::where('id', $request->event_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($item->event_id !== $event->id) {
            Log::warning('Product does not belong to this event', [
                'product_id' => $id,
                'event_id' => $event->id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Product not found in this event'
            ], 404);
        }

        // Validasi input — sesuaikan nama field form!
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'min_per_order' => 'nullable|integer|min:1',
            'max_per_order' => 'nullable|integer|min:1',
            'sale_start_date' => 'required|date',  
            'sale_end_date' => 'nullable|date|after_or_equal:start_date',
            'image' => 'nullable|image|max:5120',
        ]);

        // Update gambar jika ada upload baru
        if ($request->hasFile('image')) {
            Log::info('Image upload detected for product ' . $item->id);

            // Hapus gambar lama kalau ada
            if ($item->image && file_exists(public_path($item->image))) {
                unlink(public_path($item->image));
                Log::info('Old image deleted', ['path' => $item->image]);
            }

            // Simpan gambar baru
            $publicPath = public_path('product_images');
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
                Log::info('Product images folder created');
            }

            $imageName = time() . '_' . Str::random(10) . '.' .
                $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($publicPath, $imageName);
            $validated['image'] = 'product_images/' . $imageName;
            Log::info('New image saved', ['path' => $validated['image']]);
        }

        // Update data produk
        $item->update($validated);
        Log::info('Product updated successfully', ['product_id' => $item->id]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully!'
        ]);
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (Auth::id() !== $product->event->user_id) {
            abort(403, 'Unauthorized');
        }

        DB::transaction(function () use ($product) {
            // Hapus image jika ada
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // Ambil semua order_items dari produk ini
            foreach ($product->orderItems as $item) {
                $order = $item->order;

                // Hapus order item
                $item->delete();

                // Cek apakah order ini masih punya order_item lain selain dari produk ini
                $remainingItems = $order->items()->count();

                if ($remainingItems === 0) {
                    // Jika tidak ada item lain → hapus attendees dan order
                    $order->attendees()->delete();
                    $order->delete();
                }
            }

            // Terakhir, hapus produk
            $product->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Product and all related data have been deleted.'
        ]);
    }
}
