<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'name',
        'email',
        'status',
        'total_price',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
