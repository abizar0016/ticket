<?php

namespace App\Actions\Promos;

use App\Models\Promo;
use App\Models\Event;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StorePromo
{
    public function handle(Request $request, $eventId)
    {
        try {
            $event = Event::where('id', $eventId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:promos,code',
                'type' => 'required|in:fixed,percentage',
                'discount' => 'required|numeric|min:0',
                'max_uses' => 'nullable|integer|min:0',
                'is_ticket' => 'nullable|boolean',
                'is_merchandise' => 'nullable|boolean',
            ]);

            $validated['is_ticket'] = $request->boolean('is_ticket');
            $validated['is_merchandise'] = $request->boolean('is_merchandise');
            $validated['max_uses'] = $validated['max_uses'] ?? 1;

            DB::transaction(function () use ($validated, $event) {
                $promo = Promo::create(array_merge($validated, [
                    'event_id' => $event->id,
                ]));

                Activity::create([
                    'user_id' => Auth::id(),
                    'action' => 'create promo',
                    'model_type' => 'Promo',
                    'model_id' => $promo->id,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Promo code created successfully.',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Store Promo Error', [
                'msg' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the promo code.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
