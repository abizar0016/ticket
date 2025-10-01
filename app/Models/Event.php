<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'event_code',
        'user_id',
        'organization_id',
        'categories_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'event_image',
        'venue_name',
        'address_line',
        'city',
        'state',
        'custom_maps_url',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'event_location_id',
        'is_published',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }

}