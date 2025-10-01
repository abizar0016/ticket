<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoProduct extends Model
{
    protected $fillable = [
        'product_id',
        'promo_id',
        'type',
        'discount',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
