<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\City;
use App\Services\WeatherService;
use Illuminate\Console\Command;
use App\Models\WeatherHistory;

class FetchWeatherCommand extends Command
{
    protected $signature = 'weather:fetch';

    protected $description = 'Pobierz dane pogodowe dla wybranych miast';

    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
    }

    public function handle()
    {
        $setting = Setting::first();
        $cityIds = $setting ? $setting->city_ids : [];

        if (empty($cityIds)) {
            $this->info('Brak wybranych miast do pobrania pogody.');
            return;
        }

        $cities = City::whereIn('id', $cityIds)->get();

        foreach ($cities as $city) {
            $weatherData = $this->weatherService->getWeather($city->api_city_id);

            \App\Models\Weather::updateOrCreate(
                ['city_id' => $city->id],
                [
                    'description' => $weatherData['weather'][0]['description'] ?? 'Brak danych',
                    'temperature' => $weatherData['main']['temp'] ?? null,
                    'pressure'    => $weatherData['main']['pressure'] ?? null,
                    'humidity'    => $weatherData['main']['humidity'] ?? null,
                ]
            );

            WeatherHistory::create([
                'city_id' => $city->id,
                'temperature' => $weatherData['main']['temp'] ?? null,
                'pressure'    => $weatherData['main']['pressure'] ?? null,
                'humidity'    => $weatherData['main']['humidity'] ?? null,
                'recorded_at' => now(),
            ]);
        }

        $this->info('Pogoda została pomyślnie pobrana dla wybranych miast.');
    }
}
