@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Szczegóły pogody dla {{ $city->name }}</h1>

        <div class="card">
            <div class="card-header">
                <h4>{{ $city->name }} - Pogoda</h4>
            </div>
            <div class="card-body">
                <p><strong>Temperatura:</strong> {{ $weather->temperature }}°C</p>
                <p><strong>Wilgotność:</strong> {{ $weather->humidity }}%</p>
                <p><strong>Ciśnienie:</strong> {{ $weather->pressure }} hPa</p>
                <p><strong>Opis:</strong> {{ $weather->description }}</p>
                <p><strong>Data pomiaru:</strong> {{ $weather->created_at->format('d-m-Y H:i') }}</p>

                <a href="{{ route('weather.index') }}" class="btn btn-primary mt-3">Powrót do listy</a>
            </div>
        </div>
    </div>
@endsection
