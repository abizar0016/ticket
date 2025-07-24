<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $table = 'organizers';

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function event()
    {
        return $this->hasMany(Event::class);
    }
}
