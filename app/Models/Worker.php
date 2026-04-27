<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_provider_id',
        'user_id',
        'name',
        'cnic',
        'address',
        'phone',
        'email',
        'experience_years',
        'password',
        'is_available',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'provider_worker_id');
    }
}
