@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Aktualna Pogoda</h1>

        <p><a href="{{ route('settings.index') }}" class="btn btn-secondary btn-lg">Przejdź do ustawień miast</a></p>

        @if ($weathers->isEmpty())
            <div class="alert alert-warning mt-4">
                Brak danych pogodowych. Proszę spróbować później.
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 mt-4">
                @php
                    $weatherEmojis = [
                        'Clear' => '☀️',
                        'Clouds' => '☁️',
                        'Rain' => '🌧️',
                        'Drizzle' => '🌦️',
                        'Thunderstorm' => '⛈️',
                        'Snow' => '❄️',
                        'Mist' => '🌫️',
                        'Fog' => '🌁',
                        'Haze' => '🌤️',
                        'Dust' => '🌪️',
                        'Sand' => '🌪️',
                        'Ash' => '🌋',
                        'Squall' => '💨',
                        'Tornado' => '🌪️'
                    ];
                @endphp

                @foreach ($weathers as $weather)
                    <div class="col">
                        <div class="card text-center shadow-sm" style="min-height: 250px; font-size: 1.1em;">
                            <div class="card-body">
                                <h5 class="card-title" style="font-size: 1.4em;">{{ $weather->city_name ?? 'Nieznane miasto' }}</h5>
                                <div class="weather-icon mb-3">
                                    <span style="font-size: 2.5em;">
                                        {{ $weatherEmojis[$weather->main] ?? '❓' }}
                                    </span>
                                </div>
                                <p class="mb-2"><strong>Temperatura:</strong> {{ $weather->temperature }} °C</p>
                                <p class="mb-3"><strong>Wilgotność:</strong> {{ $weather->humidity }}%</p>
                                <a href="{{ route('weather.show', $weather->city_id) }}" class="btn btn-info btn-sm">Szczegóły</a>
                                <form action="{{ route('weather.delete', $weather->city_id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Czy na pewno chcesz usunąć to miasto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Usuń miasto</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
