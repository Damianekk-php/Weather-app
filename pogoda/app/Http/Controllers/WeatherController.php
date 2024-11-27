<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use App\Models\Setting;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function index()
    {
        // Pobierz pierwsze ustawienie, zakładając, że masz tylko jedno ustawienie
        $setting = Setting::first();

        // Sprawdź, czy istnieją ustawienia i czy zawierają city_ids
        $cityIds = $setting && isset($setting->city_ids) ? $setting->city_ids : [];

        // Jeśli są ustawione miasta, pobierz dane pogodowe dla tych miast
        $weathers = Weather::whereIn('city_id', $cityIds)->get();

        // Przekaż dane do widoku
        return view('weather.index', compact('weathers'));
    }
}

