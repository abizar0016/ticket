<?php

namespace App\Http\Controllers\Common\Checkouts;

use App\Http\Controllers\Controller;
use App\Services\Checkouts\CheckoutService;
use App\Services\Checkouts\PaymentService;
use Illuminate\Http\Request;

class CheckoutsController extends Controller
{
    protected CheckoutService $checkoutService;
    protected PaymentService $paymentService;

    public function __construct(CheckoutService $checkoutService, PaymentService $paymentService)
    {
        $this->checkoutService = $checkoutService;
        $this->paymentService = $paymentService;
    }

    public function checkout(Request $request)
    {
        return $this->checkoutService->createSession($request);
    }

    public function showCheckoutForm(Request $request, string $token)
    {
        return $this->checkoutService->showForm($token);
    }

    public function submit(Request $request)
    {
        return $this->checkoutService->submitOrder($request);
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        return $this->paymentService->uploadProof($request, $id);
    }
}
