<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $setting = Setting::first();
        $cityIds = $setting ? $setting->city_ids : [];

        $existingCities = City::whereIn('id', $cityIds)->get();

        return view('settings.index', compact('cities', 'cityIds', 'existingCities'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'city_ids' => 'required|array|max:10',
            'city_ids.*' => 'exists:cities,id',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create();
        }

        $existingCityIds = $setting->city_ids ?? [];

        $newCityIds = $request->input('city_ids');

        $newCityIds = array_unique($newCityIds);

        $totalCities = count($existingCityIds);

        if ($totalCities + count($newCityIds) > 10) {
            return redirect()->route('settings.index')->with('error', 'Możesz dodać tylko 10 miast, obecnie masz ' . $totalCities . ' miast. Usuń jakieś miasto, aby dodać nowe.');
        }

        $duplicates = array_intersect($newCityIds, $existingCityIds);

        if (count($duplicates) > 0) {
            $duplicateCityNames = City::whereIn('id', $duplicates)->pluck('name')->toArray();
            $duplicateCityNamesStr = implode(', ', $duplicateCityNames);

            return redirect()->route('settings.index')->with('error', 'Miasto(z) "' . $duplicateCityNamesStr . '" już istnieje w ustawieniach.');
        }

        $setting->city_ids = array_merge($existingCityIds, $newCityIds);
        $setting->save();

        Artisan::call('weather:fetch');

        return redirect()->route('settings.index')->with('success', 'Ustawienia zostały zapisane.');
    }

}
