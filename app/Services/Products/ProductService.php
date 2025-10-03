<?php

namespace App\Services\Products;

use App\Actions\Products\StoreProduct;
use App\Actions\Products\UpdateProduct;
use App\Actions\Products\DeleteProduct;
use Illuminate\Http\Request;

class ProductService
{
    public function store(Request $request, $eventId)
    {
        return (new StoreProduct())->handle($request, $eventId);
    }

    public function update(Request $request, $productId)
    {
        return (new UpdateProduct())->handle($request, $productId);
    }

    public function destroy($productId)
    {
        return (new DeleteProduct())->handle($productId);
    }
}
