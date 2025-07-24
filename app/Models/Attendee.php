<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = [
        'event_id',
        'product_id',
        'order_id',
        'name',
        'email',
        'ticket_type',
        'ticket_code',
        'status',
    ];

    // Attendee.php
    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
