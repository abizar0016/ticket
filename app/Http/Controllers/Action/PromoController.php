<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Models\Event;
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
            // Ambil event milik user yang sedang login
            $event = Event::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            Log::info('Store PromoCode - Event ditemukan', ['event_id' => $event->id, 'user_id' => Auth::id()]);

            // Validasi input
            $validated = $request->validate([
                'name'      => 'required|string|max:255',
                'code'      => 'required|string|max:255|unique:promo_codes,code',
                'type'      => 'required|in:fixed,percentage',
                'discount'  => 'required|numeric|min:0',
                'max_uses'  => 'nullable|integer|min:0',
            ]);

            Log::info('Store PromoCode - Data tervalidasi', $validated);

            // Simpan data dengan transaction
            DB::transaction(function () use ($validated, $event) {
                $promo = PromoCode::create([
                    'event_id'  => $event->id,
                    'name'      => $validated['name'],
                    'code'      => $validated['code'],
                    'type'      => $validated['type'],
                    'discount'  => $validated['discount'],
                    'max_uses'  => $validated['max_uses'] ?? 1,
                ]);

                Log::info('Store PromoCode - Promo code berhasil dibuat', ['promo_code_id' => $promo->id]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Promo code created successfully.',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Store PromoCode - Validasi gagal', ['errors' => $e->errors()]);

            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Store PromoCode - Terjadi error', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the promo code.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function update(Request $request, $eventId, $id)
    {
        $promoCode = PromoCode::where('event_id', $eventId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:promo_codes,code,' . $promoCode->id,
            'type' => 'required|in:fixed,percentage',
            'discount' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:0',
        ]);

        $promoCode->update([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'discount' => $request->discount,
            'max_uses' => $request->max_uses ?? 1,
        ]);

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
