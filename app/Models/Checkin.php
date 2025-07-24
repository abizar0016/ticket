<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = [
        'event_id',
        'attendee_id',
        'product_id',
        'order_id',
        'ip_address',
    ];

    public function attendee()
    {
        return $this->belongsTo(Attendee::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
