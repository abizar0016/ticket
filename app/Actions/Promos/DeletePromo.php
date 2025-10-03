<?php

namespace App\Actions\Promos;

use App\Models\Promo;
use App\Models\Order;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePromo
{
    public function handle($id)
    {
        DB::transaction(function () use ($id) {
            $promo = Promo::findOrFail($id);

            Order::where('promo_id', $id)->update(['promo_id' => null]);
            $promo->delete();

            Activity::create([
                'user_id' => Auth::id(),
                'action' => 'delete promo',
                'model_type' => 'Promo',
                'model_id' => $id,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Promo code berhasil dihapus.',
        ]);
    }
}
