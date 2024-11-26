<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['id', 'name', 'country', 'lat', 'lon'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function userSelections()
    {
        return $this->hasMany(UserCitySelection::class, 'city_id');
    }
}
