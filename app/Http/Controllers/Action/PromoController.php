<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:promo_codes,code',
            'max_uses' => 'nullable|integer|min:0',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.type' => 'required|in:fixed,percentage',
            'products.*.discount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $promoCode = PromoCode::create([
                'name' => $request->name,
                'code' => $request->code,
                'max_uses' => $request->max_uses ?? 1,
            ]);

            foreach ($request->products as $product) {
                $promoCode->products()->attach($product['product_id'], [
                    'type' => $product['type'],
                    'discount' => $product['discount'],
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Promo code created successfully.',
        ]);
    }

    public function update(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:promo_codes,code,' . $promoCode->id,
            'max_uses' => 'nullable|integer|min:0',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.type' => 'required|in:fixed,percentage',
            'products.*.discount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $promoCode) {
            $promoCode->update([
                'name' => $request->name,
                'code' => $request->code,
                'max_uses' => $request->max_uses ?? 1,
            ]);

            $promoCode->products()->detach();

            foreach ($request->products as $product) {
                $promoCode->products()->attach($product['product_id'], [
                    'type' => $product['type'],
                    'discount' => $product['discount'],
                ]);
            }
        });

        return redirect()->back()->with('success', 'Promo code updated successfully.');
    }

    public function destroy($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->delete();

        return response()->json([
            'success' => true,
            'message' => 'Promo code deleted successfully.',
        ]);
    }
}
