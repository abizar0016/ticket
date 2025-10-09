<?php

namespace App\Http\Controllers\SuperAdmin\Orders;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Event;
use App\Models\Order;

class SuperAdminOrdersController extends SuperAdminBaseController
{
    public function index()
    {
        $viewData = $this->getViewData('orders');

        $orders = Order::with(['event', 'items.product'])
            ->select('*')
            ->selectRaw('(total_price + unique_price) as uniqueAmount')
            ->latest()
            ->paginate(10);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'orders' => $orders,
        ]));
    }
}
