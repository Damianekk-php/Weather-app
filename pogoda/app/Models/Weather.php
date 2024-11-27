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
        'city_id',         // ID miasta (powiązanie z tabelą City)
        'description',     // Opis pogody (np. zachmurzenie umiarkowane)
        'temperature',     // Temperatura
        'pressure',        // Ciśnienie
        'humidity',        // Wilgotność
        'wind_speed',      // Prędkość wiatru
    ];
}
