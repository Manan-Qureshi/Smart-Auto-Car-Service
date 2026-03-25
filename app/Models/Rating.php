<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'service_provider_id',
        'rating',
        'review',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}

// update: refactor: move rating calculation to Product model scope (2026-04-07)

// update: refactor: move rating calculation to Product model scope (2026-03-25)
