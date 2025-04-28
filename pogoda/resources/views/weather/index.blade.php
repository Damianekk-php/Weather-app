@extends('layouts.app')

@section('content')
    <button id="darkModeToggle" class="dark-mode-toggle" aria-label="Przełącz tryb jasny/ciemny 🌗">
        🌗
    </button>

    <div class="container py-5">
        <h1 class="mb-5 text-center fw-bold display-4">Aktualna Pogoda</h1>

        <div class="text-center mb-4">
            <a href="{{ route('settings.index') }}" class="btn btn-primary btn-lg" aria-label="Przejdź do ustawień miast">
                Ustawienia miast
            </a>
        </div>

        @if ($weathers->isEmpty())
            <div class="alert alert-warning text-center mt-4" role="alert">
                Brak danych pogodowych. Spróbuj później.
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
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
                        <div class="card text-center shadow hover-card border-0 h-100 rounded-4" tabindex="0" role="region" aria-labelledby="city-{{ $weather->city_id }}">
                            <div class="card-body d-flex flex-column justify-content-between p-4">
                                <h2 id="city-{{ $weather->city_id }}" class="card-title fs-4 mb-3">{{ $weather->city_name ?? 'Nieznane miasto' }}</h2>
                                <div class="weather-icon mb-3" aria-hidden="true">
                                    <span style="font-size: 3em;">
                                        {{ $weatherEmojis[$weather->main] ?? '❓' }}
                                    </span>
                                </div>
                                <p class="mb-2"><strong>🌡 Temperatura:</strong> {{ $weather->temperature }} °C</p>
                                <p class="mb-4"><strong>💧 Wilgotność:</strong> {{ $weather->humidity }}%</p>
                                <div class="d-flex flex-wrap justify-content-center gap-2 mt-auto">
                                    <a href="{{ route('weather.show', $weather->city_id) }}" class="btn btn-primary btn-sm" aria-label="Szczegóły pogody w {{ $weather->city_name }}">
                                        Szczegóły
                                    </a>
                                    <form action="{{ route('weather.delete', $weather->city_id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Czy na pewno chcesz usunąć to miasto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" aria-label="Usuń miasto {{ $weather->city_name }}">
                                            Usuń
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            .dark-mode-toggle {
                position: fixed;
                top: 1rem;
                right: 1rem;
                background: var(--primary-color);
                color: #000000;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 30px;
                font-size: 1.2rem;
                cursor: pointer;
                z-index: 9999;
                transition: background 0.3s;
            }
            .dark-mode-toggle:focus {
                outline: 3px solid #00bcd4;
                outline-offset: 2px;
            }

            .hover-card {
                transition: transform 0.4s ease, box-shadow 0.4s ease;
                background: var(--card-bg);
                color: var(--text-color);
            }
            .hover-card:hover, .hover-card:focus-within {
                transform: translateY(-8px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            }
            .weather-icon span {
                display: inline-block;
                transition: transform 0.3s;
            }
            .hover-card:hover .weather-icon span {
                transform: scale(1.2);
            }

            .btn:focus-visible, .card:focus-within {
                outline: 3px solid #0d6efd;
                outline-offset: 4px;
                border-radius: 0.75rem;
            }

            :root {
                --background: #f5f7fa;
                --text-color: #212529;
                --card-bg: #ffffff;
                --primary-color: #0d6efd;
            }
            body.dark-mode {
                --background: #121212;
                --text-color: #f1f1f1;
                --card-bg: #1f1f1f;
                --primary-color: #00bcd4;
            }
            body {
                background-color: var(--background);
                color: var(--text-color);
                transition: background-color 0.3s, color 0.3s;
            }
            .card, .btn {
                transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            }

            body.dark-mode .btn-outline-primary {
                color: #ffffff;
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            body.dark-mode .btn-outline-danger {
                color: #ffffff;
                background-color: #dc3545;
                border-color: #dc3545;
            }


        </style>
    @endpush

    @push('scripts')
        <script>
            const toggleButton = document.getElementById('darkModeToggle');
            toggleButton.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
            });

            document.addEventListener('DOMContentLoaded', () => {
                if (localStorage.getItem('darkMode') === 'true' ||
                    window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.body.classList.add('dark-mode');
                }
            });
        </script>
    @endpush
@endsection
