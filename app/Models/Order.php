<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'event_id', 
        'name',
        'email',
        'phone',
        'status',
        'identity_type',
        'identity_number',
        'total_price',
        'unique_price',
        'payment_proof',
        'promo_id'
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
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
