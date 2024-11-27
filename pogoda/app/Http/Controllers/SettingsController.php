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
        // Walidacja wejścia
        $request->validate([
            'city_ids' => 'required|array|max:10', // Maksymalnie 10 miast
            'city_ids.*' => 'exists:cities,id', // Każde miasto musi istnieć w bazie
        ]);

        // Pobieramy aktualne ustawienia
        $setting = Setting::first();

        // Jeżeli nie ma ustawienia, tworzymy nowe
        if (!$setting) {
            $setting = Setting::create();
        }

        // Pobieramy aktualnie zapisane id miast
        $existingCityIds = $setting->city_ids ?? [];

        // Łączymy istniejące i nowe miasta
        $newCityIds = $request->input('city_ids');

        // Zastosowujemy array_unique, aby nie było duplikatów, oraz ograniczamy do 10 miast
        $newCityIds = array_unique($newCityIds);
        $newCityIds = array_slice($newCityIds, 0, 10);

        // Zapisujemy zaktualizowaną listę miast
        $setting->city_ids = $newCityIds;
        $setting->save();

        // Przekierowanie z komunikatem o sukcesie
        return redirect()->route('settings.index')->with('success', 'Ustawienia zostały zapisane.');
    }
}

