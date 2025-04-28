<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;



Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
Route::get('/', [WeatherController::class, 'index'])->name('weather.index');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
Route::get('/weather/{city_id}', [WeatherController::class, 'show'])->name('weather.show');
Route::delete('/weather/{cityId}', [WeatherController::class, 'destroy'])->name('weather.delete');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
