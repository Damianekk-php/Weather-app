<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCitySelection extends Model
{
    protected $fillable = ['user_id', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
