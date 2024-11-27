<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use App\Models\Setting;
use App\Models\City;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        $cityIds = $setting && isset($setting->city_ids) ? $setting->city_ids : [];

        $weathers = Weather::whereIn('city_id', $cityIds)->get();

        // Uzupełniamy dane o miastach
        foreach ($weathers as $weather) {
            $weather->city_name = City::find($weather->city_id)->name ?? 'Nieznane miasto';
        }

        return view('weather.index', compact('weathers'));
    }

    public function show($id)
    {
        // Pobieramy szczegóły pogody dla miasta
        $weather = Weather::where('city_id', $id)->first();

        // Jeśli nie ma pogody, zwrócimy błąd 404
        if (!$weather) {
            return abort(404, 'Pogoda dla tego miasta nie została znaleziona.');
        }

        $city = City::find($id);
        $weather->city_name = $city ? $city->name : 'Nieznane miasto';

        return view('weather.show', compact('weather'));
    }
}

