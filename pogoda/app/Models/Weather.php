<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id',
        'city_name',
        'latitude',
        'longitude',
        'description',
        'main',
        'temperature',
        'pressure',
        'humidity',

    ];
}
