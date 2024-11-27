<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use App\Models\Setting;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        $cityIds = $setting && isset($setting->city_ids) ? $setting->city_ids : [];
        $weathers = Weather::whereIn('city_id', $cityIds)->get();

        foreach ($weathers as $weather) {
            $weather->city_name = City::find($weather->city_id)->name ?? 'Nieznane miasto';
        }

        return view('weather.index', compact('weathers'));
    }

    public function show($city_id)
    {
        $city = City::findOrFail($city_id);

        $lat = $city->lat;
        $lon = $city->lon;

        $weather = Weather::where('city_id', $city_id)->first();

        $start = now()->subDay()->timestamp;
        $end = now()->timestamp;

        // API Key do OpenWeatherMap
        $apiKey = env('OPENWEATHER_API_KEY');

        // Wysyłanie zapytania do API o dane historyczne
        $response = Http::get("https://history.openweathermap.org/data/2.5/history/city", [
            'lat' => $lat,
            'lon' => $lon,
            'type' => 'hour',
            'start' => $start,
            'end' => $end,
            'appid' => $apiKey
        ]);

        // Logowanie odpowiedzi API dla debugowania
        \Log::info('OpenWeatherMap Response:', $response->json());

        $historicalData = $response->json();

        $historicalWeather = null;
        // Jeśli odpowiedź zawiera dane historyczne, przypisujemy je
        if (isset($historicalData['list'])) {
            $historicalWeather = $historicalData['list'][0]; // Pierwszy wpis z danych godzinowych
        }

        // Jeśli brak danych historycznych, wyświetl komunikat
        if (!$historicalWeather) {
            \Log::warning('Brak danych historycznych dla miasta o współrzędnych lat: ' . $lat . ', lon: ' . $lon);
        }

        return view('weather.show', compact('weather', 'historicalWeather'));
    }
}
