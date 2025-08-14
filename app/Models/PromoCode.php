<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $table = 'promo_codes';

    protected $fillable = [
        'event_id',
        'name',
        'code',
        'discount',
        'type',
        'max_uses',
        'is_ticket',
        'is_merchandise'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'promo_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
