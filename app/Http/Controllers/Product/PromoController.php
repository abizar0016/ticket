<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'code' => 'required|string|max:255|unique:promo_codes,code,NULL,id,product_id,' . $request->product_id,
            'discount' => 'required|numeric|min:0|max:100',
            'type' => 'required|in:fixed,percentage',
            'max_uses' => 'nullable|integer|min:0',
        ]);

        PromoCode::create([
            'product_id' => $validated['product_id'],
            'code' => $validated['code'],
            'discount' => $validated['discount'],
            'type' => $validated['type'],
            'max_uses' => $validated['max_uses'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Promo code created successfully.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'code' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0|max:100',
            'type' => 'required|in:fixed,percentage',
            'max_uses' => 'nullable|integer|min:0',
        ]);

        $promoCode->product_id = $request->product_id;
        $promoCode->code = $request->code;
        $promoCode->discount = $request->discount;
        $promoCode->type = $request->type;
        $promoCode->max_uses = $request->max_uses;
        $promoCode->save();

        return redirect()->back()->with('success', 'Promo code updated successfully.');
    }

    public function destroy($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->delete();
        return redirect()->back()->with('success', 'Promo code deleted successfully.');
    }
}
