<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['city_ids'];

    protected $casts = [
        'city_ids' => 'array',
    ];

    public function addCity($cityId)
    {
        $cityIds = $this->city_ids ?: [];

        if (count($cityIds) >= 10) {
            return false;
        }

        $cityIds[] = $cityId;

        $this->city_ids = $cityIds;
        $this->save();

        return true;
    }
}
