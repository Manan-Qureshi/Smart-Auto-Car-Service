<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'base_price',
        'duration_minutes',
        'description',
        'image',
        'car_type_id',
        'car_model_id',
    ];

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function providerServices()
    {
        return $this->hasMany(ProviderService::class);
    }

    public function providers()
    {
        return $this->belongsToMany(ServiceProvider::class, 'provider_services')
                    ->withPivot('is_available')
                    ->withTimestamps();
    }
}

// update: refactor: clean up OrderController, extract to OrderService (2026-03-09)

// update: refactor: clean up OrderController, extract to OrderService (2026-03-08)
