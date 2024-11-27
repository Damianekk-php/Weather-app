<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\City;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        // Pobieramy wszystkie miasta
        $cities = City::all();

        // Pobieramy ustawienia
        $setting = Setting::first();
        // Pobieramy zapisane city_ids
        $cityIds = $setting ? $setting->city_ids : [];

        // Przekazujemy dane do widoku
        return view('settings.index', compact('cities', 'cityIds'));
    }

    public function update(Request $request)
    {
        // Walidacja, sprawdzamy, czy miasta są w tabeli cities
        $request->validate([
            'city_ids' => 'array|max:10',  // Maksymalnie 10 miast
            'city_ids.*' => 'exists:cities,id',  // Sprawdzamy, czy miasta istnieją
        ]);

        // Pobieramy ustawienia, jeśli nie istnieją to tworzymy nowe
        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create();
        }

        // Pobieramy istniejącą listę city_ids
        $existingCityIds = $setting->city_ids ?? [];

        // Łączymy istniejące miasta z nowymi
        $newCityIds = array_merge($existingCityIds, $request->input('city_ids'));

        // Usuwamy duplikaty i ograniczamy do maksymalnie 10 miast
        $newCityIds = array_unique($newCityIds);
        $newCityIds = array_slice($newCityIds, 0, 10);

        // Zapisujemy nową listę miast w ustawieniach
        $setting->city_ids = $newCityIds;
        $setting->save();

        // Przekierowujemy z komunikatem sukcesu
        return redirect()->route('settings.index')->with('success', 'Ustawienia zostały zapisane.');
    }
}
