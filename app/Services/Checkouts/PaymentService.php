<?php

namespace App\Services\Checkouts;

use App\Actions\Checkouts\UploadPaymentProof;
use Illuminate\Http\Request;

class PaymentService
{
    public function uploadProof(Request $request, $orderId)
    {
        return (new UploadPaymentProof())->handle($request, $orderId);
    }
}
