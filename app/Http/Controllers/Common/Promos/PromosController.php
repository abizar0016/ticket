<?php

namespace App\Http\Controllers\Common\Promos;

use App\Http\Controllers\Controller;
use App\Services\Promos\PromoService;
use Illuminate\Http\Request;

class PromosController extends Controller
{
    protected PromoService $service;

    public function __construct(PromoService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request, $eventId)
    {
        return $this->service->store($request, $eventId);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

    public function applyPromo(Request $request)
    {
        $validated = $request->validate([
            'promo_code' => 'required|string|max:50',
            'token' => 'required|string',
        ]);

        return $this->service->applyPromo($validated['token'], $validated['promo_code']);
    }

    public function removePromo(Request $request)
    {
        $validated = $request->validate(['token' => 'required|string']);

        return $this->service->removePromo($validated['token']);
    }
}
