<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENWEATHER_API_KEY');
    }

    public function getWeather($cityId)
    {
        $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
            'id' => $cityId,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'pl',
        ]);

        return $response->json();
    }
}
