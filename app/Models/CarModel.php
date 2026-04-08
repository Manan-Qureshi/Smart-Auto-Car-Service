<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $fillable = ['car_type_id', 'name', 'price_modifier'];

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }
}

// update: added car types (2026-04-13)

// update: added car types (2026-04-08)
