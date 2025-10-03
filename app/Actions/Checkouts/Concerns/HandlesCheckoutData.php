<?php

namespace App\Actions\Checkouts\Concerns;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

trait HandlesCheckoutData
{
    public function getCheckoutData(string $token): ?array
    {
        $data = Cache::get('checkout:' . $token);

        if (!$data && Session::get('checkout_token') === $token) {
            $data = Session::get('checkout_data');
        }

        if (!$data || !isset($data['token']) || $data['token'] !== $token) {
            return null;
        }

        if (isset($data['expires_at']) && Carbon::parse($data['expires_at'])->isPast()) {
            return null;
        }

        return $data;
    }
}
