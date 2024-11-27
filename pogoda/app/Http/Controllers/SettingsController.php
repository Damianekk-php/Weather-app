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

        return view('settings.index', compact('cities', 'cityIds'));
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
        $newCityIds = array_slice($newCityIds, 0, 10);

        $setting->city_ids = $newCityIds;
        $setting->save();
        Artisan::call('weather:fetch');

        return redirect()->route('settings.index')->with('success', 'Ustawienia zostały zapisane.');
    }
}

