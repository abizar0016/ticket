<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'type',
        'title',
        'description',
        'price',
        'quantity',
        'min_per_order',
        'max_per_order',
        'sale_start_date',
        'sale_end_date',
        'image',
        'event_id',
    ];

    protected $casts = [
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
    ];

    public function getStatusText(): string
    {
        $now = now();

        if ($this->sale_start_date > $now) {
            return 'Upcoming';
        }

        if ($this->sale_end_date && $this->sale_end_date < $now) {
            return 'Ended';
        }

        return 'Available';
    }

    public function getStatusBadgeClass(): string
    {
        $status = $this->getStatusText();

        return match ($status) {
            'Available' => 'bg-green-100 text-green-800',
            'Upcoming' => 'bg-blue-100 text-blue-800',
            'Ended' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getSoldCount(): int
    {
        return $this->orderItems()
            ->whereHas('order', fn($q) => $q->where('status', 'paid'))
            ->sum('quantity');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function promo()
    {
        return $this->hasMany(Promo::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }
}
