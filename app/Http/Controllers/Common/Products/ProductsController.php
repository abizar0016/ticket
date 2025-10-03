<?php

namespace App\Http\Controllers\Common\Products;

use App\Http\Controllers\Controller;
use App\Services\Products\ProductService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request, $eventId)
    {
        return $this->service->store($request, $eventId);
    }

    public function update(Request $request, $productId)
    {
        return $this->service->update($request, $productId);
    }

    public function destroy($productId)
    {
        return $this->service->destroy($productId);
    }
}
