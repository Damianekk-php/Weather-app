<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    // 1. Wyświetl aktualną pogodę dla miast
    public function index()
    {
        $cities = City::all();


        $citiesWeather = $cities->map(function ($city) {
            $weather = $this->weatherService->getWeather($city->api_city_id);
            return (object) [
                'name' => $city->name,
                'weather' => (object) [
                    'description' => $weather['weather'][0]['description'] ?? 'Brak danych',
                    'temperature' => $weather['main']['temp'] ?? 'Brak danych',
                    'pressure' => $weather['main']['pressure'] ?? 'Brak danych',
                    'humidity' => $weather['main']['humidity'] ?? 'Brak danych',
                ],
            ];
        });


        return view('weather.index', compact('citiesWeather'));
    }


    public function settings()
    {
        $cities = City::all();
        return view('weather.settings', compact('cities'));
    }


    public function updateSettings(Request $request)
    {
        // Walidacja
        $validated = $request->validate([
            'cities' => 'required|array',
            'cities.*.name' => 'required|string',
            'cities.*.api_city_id' => 'required|integer',
        ]);


        City::truncate();
        foreach ($validated['cities'] as $city) {
            City::create($city);
        }

        return redirect()->route('cities.settings')->with('success', 'Ustawienia zostały zaktualizowane!');
    }
}
