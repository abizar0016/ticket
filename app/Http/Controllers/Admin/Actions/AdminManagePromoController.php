<?php

namespace App\Http\Controllers\Admin\Actions;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminManagePromoController extends Controller
{
    public function store(Request $request, $id)
    {
        try {
            $event = Event::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            Log::info('Store PromoCode - Event found', [
                'event_id' => $event->id,
                'user_id' => Auth::id()
            ]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:promo_codes,code',
                'type' => 'required|in:fixed,percentage',
                'discount' => 'required|numeric|min:0',
                'max_uses' => 'nullable|integer|min:0',
                'is_ticket' => 'nullable|boolean',
                'is_merchandise' => 'nullable|boolean',
            ]);

            $validated['is_ticket'] = $request->boolean('is_ticket');
            $validated['is_merchandise'] = $request->boolean('is_merchandise');
            $validated['max_uses'] = $validated['max_uses'] ?? 1;

            Log::info('Store PromoCode - Data validated', $validated);

            DB::transaction(function () use ($validated, $event) {
                $promo = PromoCode::create([
                    'event_id' => $event->id,
                    'name' => $validated['name'],
                    'code' => $validated['code'],
                    'type' => $validated['type'],
                    'discount' => $validated['discount'],
                    'max_uses' => $validated['max_uses'],
                    'is_ticket' => $validated['is_ticket'],
                    'is_merchandise' => $validated['is_merchandise'],
                ]);

                Log::info('Store PromoCode - Promo code created successfully', [
                    'promo_code_id' => $promo->id
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Promo code created successfully.',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Store PromoCode - Validation failed', [
                'errors' => $e->errors()
            ]);

            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Store PromoCode - Error occurred', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the promo code.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $promoCode = PromoCode::where('id', $id)
                ->whereHas('event', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->firstOrFail();

            Log::info('Update PromoCode - Promo code found', [
                'promo_code_id' => $promoCode->id,
                'event_id' => $promoCode->event_id,
                'user_id' => Auth::id()
            ]);

            Log::info('Update PromoCode - Request data', [
                'all_data' => $request->all(),
                'is_ticket_raw' => $request->input('is_ticket'),
                'is_merchandise_raw' => $request->input('is_merchandise'),
                'is_ticket_boolean' => $request->boolean('is_ticket'),
                'is_merchandise_boolean' => $request->boolean('is_merchandise')
            ]);

            $validationRules = [
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:promo_codes,code,' . $promoCode->id,
                'type' => 'required|in:fixed,percentage',
                'max_uses' => 'nullable|integer|min:0',
                'is_ticket' => 'nullable',
                'is_merchandise' => 'nullable',
            ];

            if ($request->type === 'percentage') {
                $validationRules['discount'] = 'required|numeric|min:0|max:100';
            } else {
                $validationRules['discount'] = 'required|numeric|min:0|max:1000000';
            }

            $validated = $request->validate($validationRules);

            $validated['is_ticket'] = $request->has('is_ticket') ? $request->boolean('is_ticket') : false;
            $validated['is_merchandise'] = $request->has('is_merchandise') ? $request->boolean('is_merchandise') : false;

            $validated['max_uses'] = $validated['max_uses'] ?? ($promoCode->max_uses ?? 1);

            Log::info('Update PromoCode - Data validated', $validated);

            DB::transaction(function () use ($validated, $promoCode) {
                $promoCode->update([
                    'name' => $validated['name'],
                    'code' => $validated['code'],
                    'type' => $validated['type'],
                    'discount' => $validated['discount'],
                    'max_uses' => $validated['max_uses'],
                    'is_ticket' => $validated['is_ticket'],
                    'is_merchandise' => $validated['is_merchandise'],
                ]);

                Log::info('Update PromoCode - Promo code updated successfully', [
                    'promo_code_id' => $promoCode->id,
                    'updated_data' => $promoCode->fresh()->toArray()
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Promo code updated successfully.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Update PromoCode - Resource not found', [
                'error_message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Promo code not found or you do not have permission to update it.',
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Update PromoCode - Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Update PromoCode - Error occurred', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the promo code.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function destroy($id)
    {
        $promo = PromoCode::findOrFail($id);
        Order::where('promo_id', $id)->update(['promo_id' => null]);
        $promo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Promo code berhasil dihapus.'
        ]);
    }

}