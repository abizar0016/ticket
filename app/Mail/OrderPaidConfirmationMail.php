<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPaidConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $recipientName;
    public $event;

    public function __construct(Order $order, string $recipientName)
    {
        $this->order = $order;
        $this->recipientName = $recipientName;
        $this->event = $order->items->first()?->product?->event;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pembayaran Pesanan Anda')
                    ->markdown('emails.orders.order_paid_confirmation', [
                        'order' => $this->order,
                        'recipientName' => $this->recipientName,
                        'event' => $this->event,
                    ]);
    }
}
