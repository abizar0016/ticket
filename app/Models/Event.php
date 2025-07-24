<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'event_code',
        'user_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'timezone',
        'event_image',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'event_location_id',
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

    public function location()
    {
        return $this->hasOne(EventLocation::class);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }

}