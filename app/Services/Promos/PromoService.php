<?php

namespace App\Services\Promos;

use App\Actions\Promos\ApplyPromo;
use App\Actions\Promos\DeletePromo;
use App\Actions\Promos\RemovePromo;
use App\Actions\Promos\StorePromo;
use App\Actions\Promos\UpdatePromo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\{Cache, Session};

class PromoService
{
    public function store(Request $request, $eventId)
    {
        return (new StorePromo)->handle($request, $eventId);
    }

    public function update(Request $request, $id)
    {
        return (new UpdatePromo)->handle($request, $id);
    }

    public function destroy($id)
    {
        return (new DeletePromo)->handle($id);
    }

    public function applyPromo(string $token, string $promoCode)
    {
        return (new ApplyPromo)->handle($token, $promoCode);
    }

    public function removePromo(string $token)
    {
        return (new RemovePromo)->handle($token);
    }

    public function getCheckoutData(string $token): ?array
    {
        $data = Cache::get('checkout:'.$token);

        if (! $data && Session::get('checkout_token') === $token) {
            $data = Session::get('checkout_data');
        }

        if (! $data || ! isset($data['token']) || $data['token'] !== $token) {
            return null;
        }

        if (isset($data['expires_at']) && Carbon::parse($data['expires_at'])->isPast()) {
            return null;
        }

        return $data;
    }
}
