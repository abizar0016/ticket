<?php

namespace App\Services\Orders;

use App\Actions\Orders\MarkAsPaid;
use App\Actions\Orders\MarkAsPending;
use App\Actions\Orders\UpdateOrder;
use App\Actions\Orders\DeleteOrder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderService
{
    public function markAsPaid(int $id): JsonResponse
    {
        return (new MarkAsPaid())->handle($id);
    }

    public function markAsPending(int $id): JsonResponse
    {
        return (new MarkAsPending())->handle($id);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        return (new UpdateOrder())->handle($request, $id);
    }

    public function delete(int $id): JsonResponse
    {
        return (new DeleteOrder())->handle($id);
    }
}
