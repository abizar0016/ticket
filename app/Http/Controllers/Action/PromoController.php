<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromoController extends Controller
{
    public function store(Request $request, $id)
    {
        try {
            // Get event belonging to the logged-in user
            $event = Event::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            Log::info('Store PromoCode - Event found', [
                'event_id' => $event->id,
                'user_id' => Auth::id()
            ]);

            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:promo_codes,code',
                'type' => 'required|in:fixed,percentage',
                'discount' => 'required|numeric|min:0',
                'max_uses' => 'nullable|integer|min:0',
                'is_ticket' => 'nullable|boolean',
                'is_merchandise' => 'nullable|boolean',
            ]);

            // Normalize boolean values
            $validated['is_ticket'] = $request->boolean('is_ticket');
            $validated['is_merchandise'] = $request->boolean('is_merchandise');
            $validated['max_uses'] = $validated['max_uses'] ?? 1;

            Log::info('Store PromoCode - Data validated', $validated);

            // Save data with transaction
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
            // Get promo code belonging to the event and user
            $promoCode = PromoCode::where('event_id', $id)
                ->whereHas('event', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->findOrFail($id);

            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:promo_codes,code,' . $promoCode->id,
                'type' => 'required|in:fixed,percentage',
                'discount' => 'required|numeric|min:0',
                'max_uses' => 'nullable|integer|min:0',
                'is_ticket' => 'nullable|boolean',
                'is_merchandise' => 'nullable|boolean',
            ]);

            // Normalize boolean values
            $validated['is_ticket'] = $request->boolean('is_ticket');
            $validated['is_merchandise'] = $request->boolean('is_merchandise');
            $validated['max_uses'] = $validated['max_uses'] ?? 1;

            // Update promo code
            $promoCode->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Promo code updated successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
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

        return redirect()->back()->with('success', 'Promo code berhasil dihapus.');
    }

}