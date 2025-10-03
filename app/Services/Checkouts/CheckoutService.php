<?php

namespace App\Services\Checkouts;

use App\Actions\Checkouts\CreateCheckoutSession;
use App\Actions\Checkouts\SubmitCheckout;
use App\Actions\Checkouts\ShowCheckoutForm;
use Illuminate\Http\Request;

class CheckoutService
{
    public function createSession(Request $request)
    {
        return (new CreateCheckoutSession())->handle($request);
    }

    public function showForm(string $token)
    {
        return (new ShowCheckoutForm())->handle($token);
    }

    public function submitOrder(Request $request)
    {
        return (new SubmitCheckout())->handle($request);
    }
}
