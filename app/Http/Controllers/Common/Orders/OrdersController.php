<?php

namespace App\Http\Controllers\Common\Orders;

use App\Http\Controllers\Controller;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct(protected OrderService $service) {}

    public function markAsPaid($id)
    {
        return $this->service->markAsPaid($id);
    }

    public function markAsPending($id)
    {
        return $this->service->markAsPending($id);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
