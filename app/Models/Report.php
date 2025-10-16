<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'user_id',
        'event_id',
        'reason',
        'description',
        'admin_reply',
        'admin_replied_at',
        'super_admin_reply',
        'super_admin_replied_at',
        'escalated_at',
        'status',
    ];

    protected $casts = [
        'admin_replied_at' => 'datetime',
        'super_admin_replied_at' => 'datetime',
        'escalated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}

