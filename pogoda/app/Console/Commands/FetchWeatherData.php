<?php

namespace App\Console\Commands;

use App\Models\UserCitySelection;
use App\Models\Weather;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchWeatherData extends Command
{
    protected $signature = 'weather:fetch';
    protected $description = 'Pobierz dane pogodowe z API dla wybranych miast';

    public function handle()
    {
        // Pobierz klucz API z konfiguracji
        $apiKey = config('services.openweather.api_key');

        // Pobierz miasta wybrane przez użytkowników
        $cities = UserCitySelection::with('city')->get();

        foreach ($cities as $selection) {
            $city = $selection->city;

            // Wywołaj API OpenWeather dla każdego miasta
            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'id' => $city->id,
                'appid' => $apiKey,
                'units' => 'metric',
            ]);

            if ($response->ok()) {
                $data = $response->json();
                Weather::updateOrCreate(
                    ['city_id' => $city->id],
                    [
                        'temperature' => $data['main']['temp'],
                        'humidity' => $data['main']['humidity'],
                        'description' => $data['weather'][0]['description'],
                    ]
                );
            }
        }

        $this->info('Dane pogodowe zostały zaktualizowane.');
    }
}
