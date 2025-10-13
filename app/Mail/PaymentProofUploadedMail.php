<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentProofUploadedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $customer;

    public function __construct(Order $order, User $customer)
    {
        $this->order = $order;
        $this->customer = $customer;
    }

    public function build()
    {
        return $this->subject('Bukti Pembayaran Baru untuk Event Anda')
                    ->markdown('emails.orders.payment_proof_uploaded');
    }
}
