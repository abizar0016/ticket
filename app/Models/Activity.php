<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🧠 Accessor untuk membuat link otomatis
public function getLinkAttribute()
{
    if (! $this->model_type || ! $this->model_id) {
        return null;
    }

    // ===================================================
    // Jika action Delete, tidak ada link
    // ===================================================
    if (isset($this->action) && $this->action === 'Delete') {
        return null;
    }

    try {
        switch ($this->model_type) {

            case 'User':
            case 'App\\Models\\User':
                return route('superAdmin.users', $this->model_id);

            case 'Organization':
            case 'App\\Models\\Organization':
                return route('superAdmin.organizations', $this->model_id);

            case 'Event':
            case 'App\\Models\\Event':
                return route('events.show', $this->model_id);

            case 'Attendee':
            case 'App\\Models\\Attendee':
                $attendee = \App\Models\Attendee::find($this->model_id);
                if ($attendee && $attendee->event_id) {
                    return route('superAdmin.events.attendees', ['eventId' => $attendee->event_id]);
                }
                return null;

            case 'Product':
            case 'App\\Models\\Product':
                $product = \App\Models\Product::find($this->model_id);
                if ($product && $product->event_id) {
                    return route('superAdmin.events.products', ['eventId' => $product->event_id]);
                }
                return null;

            case 'Checkin':
            case 'App\\Models\\Checkin':
                $checkin = \App\Models\Checkin::find($this->model_id);
                if ($checkin && $checkin->event_id) {
                    return route('superAdmin.events.checkins', ['eventId' => $checkin->event_id]);
                }
                return null;

            case 'Order':
            case 'App\\Models\\Order':
                return route('orders.show', $this->model_id);

            case 'Promo':
            case 'App\\Models\\Promo':
                $promo = \App\Models\Promo::find($this->model_id);
                if ($promo && $promo->event_id) {
                    return route('superAdmin.events.promos', ['eventId' => $promo->event_id]);
                }
                return null;

            case 'Category':
            case 'App\\Models\\Category':
                return route('superAdmin.events.categories');

            default:
                return null;
        }
    } catch (\Throwable $e) {
        return null;
    }
}

}
