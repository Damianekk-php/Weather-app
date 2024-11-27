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

                <a href="{{ route('weather.index') }}" class="btn btn-secondary">Powrót do listy</a>
            </div>
        </div>
    </div>
@endsection
