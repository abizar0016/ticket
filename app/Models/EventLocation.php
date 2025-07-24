<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLocation extends Model
{
    protected $table = 'event_locations';

    protected $fillable = [
        'event_id',
        'venue_name',
        'address_line',
        'city',
        'state',
        'custom_maps_url',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
