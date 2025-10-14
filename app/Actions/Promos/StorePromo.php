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
            // 🔒 Ambil event yang sesuai user login
            $event = Event::where('id', $eventId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // ✅ Validasi input
            $validated = $request->validate([
                'name'          => 'required|string|max:255',
                'code'          => 'required|string|max:255|unique:promos,code',
                'type'          => 'required|in:fixed,percentage',
                'discount'      => 'required|numeric|min:0',
                'max_uses'      => 'nullable|integer|min:0',
                'is_ticket'     => 'nullable|boolean',
                'is_merchandise'=> 'nullable|boolean',
            ]);

            // 🔧 Normalisasi nilai boolean dan default
            $validated['is_ticket']      = $request->boolean('is_ticket');
            $validated['is_merchandise'] = $request->boolean('is_merchandise');
            $validated['max_uses']       = $validated['max_uses'] ?? 1;

            // ==============================
            // 🚀 Eksekusi transaksi
            // ==============================
            $promo = DB::transaction(function () use ($validated, $event) {
                return Promo::create(array_merge($validated, [
                    'event_id' => $event->id,
                ]));
            });

            // ==============================
            // 🧠 Catat activity setelah commit
            // ==============================
            DB::afterCommit(function () use ($promo) {
                Activity::create([
                    'user_id'    => Auth::id(),
                    'action'     => 'Create',
                    'model_type' => 'Promo',
                    'model_id'   => $promo->id,
                ]);
            });

            // ==============================
            // ✅ Respon sukses
            // ==============================
            return response()->json([
                'success' => true,
                'message' => 'Promo code created successfully.',
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // ⚠️ Error validasi
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {
            // 🚨 Error umum
            Log::error('Store Promo Error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the promo code.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
