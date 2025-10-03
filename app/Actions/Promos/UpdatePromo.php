<?php

namespace App\Actions\Promos;

use App\Models\Promo;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePromo
{
    public function handle(Request $request, $id)
    {
        try {
            $promo = Promo::where('id', $id)
                ->whereHas('event', fn($q) => $q->where('user_id', Auth::id()))
                ->firstOrFail();

            $rules = [
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:promos,code,' . $promo->id,
                'type' => 'required|in:fixed,percentage',
                'max_uses' => 'nullable|integer|min:0',
                'is_ticket' => 'nullable',
                'is_merchandise' => 'nullable',
            ];

            if ($request->type === 'percentage') {
                $rules['discount'] = 'required|numeric|min:0|max:100';
            } else {
                $rules['discount'] = 'required|numeric|min:0|max:1000000';
            }

            $validated = $request->validate($rules);

            $validated['is_ticket'] = $request->has('is_ticket') ? $request->boolean('is_ticket') : false;
            $validated['is_merchandise'] = $request->has('is_merchandise') ? $request->boolean('is_merchandise') : false;
            $validated['max_uses'] = $validated['max_uses'] ?? $promo->max_uses ?? 1;

            DB::transaction(function () use ($validated, $promo) {
                $promo->update($validated);

                Activity::create([
                    'user_id' => Auth::id(),
                    'action' => 'update promo',
                    'model_type' => 'Promo',
                    'model_id' => $promo->id,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Promo code updated successfully.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Promo code not found or not yours.',
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Update Promo Error', ['msg' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the promo code.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
