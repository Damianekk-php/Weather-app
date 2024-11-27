<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use App\Models\Setting;
use App\Models\City;
use App\Models\WeatherHistory;
use Illuminate\Http\Request;

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

    public function show($cityId)
    {
        $currentWeather = Weather::where('city_id', $cityId)->first();

        $history = WeatherHistory::where('city_id', $cityId)
            ->orderBy('recorded_at', 'asc')
            ->get();

        if (!$currentWeather) {
            abort(404, 'Brak danych pogodowych dla tego miasta.');
        }

        return view('weather.show', compact('currentWeather', 'history'));
    }
}
