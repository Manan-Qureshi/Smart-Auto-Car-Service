<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeDuration extends Model
{
    protected $fillable = ['minutes', 'label'];

    public static function ordered()
    {
        return static::orderBy('minutes')->get();
    }
}
