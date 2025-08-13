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
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // In PromoCode model
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
