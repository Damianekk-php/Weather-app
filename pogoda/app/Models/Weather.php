<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $fillable = ['city_id', 'temperature', 'humidity', 'description'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
