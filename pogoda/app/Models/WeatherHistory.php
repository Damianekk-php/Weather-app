<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherHistory extends Model
{
    use HasFactory;

    // Nazwa tabeli, jeśli różni się od domyślnej (domyślna: weather_histories)
    protected $table = 'weather_history';

    protected $fillable = [
        'city_id',
        'temperature',
        'pressure',
        'humidity',
        'recorded_at',
    ];
}
