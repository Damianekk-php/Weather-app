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
        $request->validate([
            'city_ids' => 'array|max:10',
            'city_ids.*' => 'exists:cities,id',
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create();
        }

        $existingCityIds = $setting->city_ids ?? [];


        $newCityIds = array_merge($existingCityIds, $request->input('city_ids'));

        $newCityIds = array_unique($newCityIds);
        $newCityIds = array_slice($newCityIds, 0, 10);

        $setting->city_ids = $newCityIds;
        $setting->save();

        return redirect()->route('settings.index')->with('success', 'Ustawienia zostały zapisane.');
    }
}
