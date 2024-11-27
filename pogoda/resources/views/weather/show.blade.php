@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Szczegóły Pogody - {{ $weather->city_name }}</h1>

        <div class="card">
            <div class="card-header">
                <h4>Informacje o Pogodzie</h4>
            </div>
            <div class="card-body">
                <p><strong>Temperatura:</strong> {{ $weather->temperature }} °C</p>
                <p><strong>Wilgotność:</strong> {{ $weather->humidity }}%</p>
                <p><strong>Ciśnienie:</strong> {{ $weather->pressure }} hPa</p>
                <p><strong>Prędkość wiatru:</strong> {{ $weather->wind_speed }} km/h</p>
                <p><strong>Opis:</strong> {{ $weather->description }}</p>

                @if ($historicalWeather)
                    <hr>
                    <h4>Dane Historyczne (w ciągu ostatnich 24 godzin)</h4>
                    <p><strong>Temperatura:</strong> {{ $historicalWeather['main']['temp'] - 273.15 }} °C</p> <!-- Zamieniamy z Kelvinów na Celsjusze -->
                    <p><strong>Wilgotność:</strong> {{ $historicalWeather['main']['humidity'] }}%</p>
                    <p><strong>Ciśnienie:</strong> {{ $historicalWeather['main']['pressure'] }} hPa</p>
                    <p><strong>Prędkość wiatru:</strong> {{ $historicalWeather['wind']['speed'] }} m/s</p>
                    <p><strong>Opis:</strong> {{ $historicalWeather['weather'][0]['description'] }}</p>
                @else
                    <p>Brak danych historycznych dla tego miasta.</p>
                @endif

                <a href="{{ route('weather.index') }}" class="btn btn-secondary mt-3">Powrót do listy</a>
            </div>
        </div>
    </div>
@endsection
