<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\UserCitySelection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $userSelections = UserCitySelection::where('user_id', Auth::id())->pluck('city_id')->toArray();

        return view('cities.index', compact('cities', 'userSelections'));
    }

    public function selectCity(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
        ]);

        UserCitySelection::updateOrCreate(
            ['user_id' => Auth::id(), 'city_id' => $request->city_id]
        );

        return redirect()->back()->with('success', 'Miasto zostało zapisane!');
    }
}
