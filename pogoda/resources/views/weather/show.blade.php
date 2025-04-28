@extends('layouts.app')

@section('content')
    <button id="darkModeToggle" class="dark-mode-toggle" aria-label="Przełącz tryb ciemny/jasny">
        🌙
    </button>

    <div class="container py-5" style="background: linear-gradient(135deg, #eef2f7 0%, #f9fafe 100%); border-radius: 20px;">
        <div class="text-center mb-5">
            <h1 class="fw-bold display-4 text-primary-emphasis">🌤️ Szczegóły pogody dla: {{ $currentWeather->city_name }}</h1>
            <a href="{{ route('weather.index') }}" class="btn btn-primary btn-lg mt-4 shadow-sm" aria-label="Powrót do listy pogody">
                🔙 Przejdź do Pogody
            </a>
        </div>

        <section class="mb-5">
            <h2 class="h3 fw-semibold mb-4 text-secondary">Aktualne dane</h2>
            <ul class="list-group list-group-flush shadow rounded-4 bg-white">
                <li class="list-group-item bg-light"><strong>Opis:</strong> {{ $currentWeather->description }}</li>
                <li class="list-group-item"><strong>Temperatura:</strong> {{ $currentWeather->temperature }} °C</li>
                <li class="list-group-item bg-light"><strong>Ciśnienie:</strong> {{ $currentWeather->pressure }} hPa</li>
                <li class="list-group-item"><strong>Wilgotność:</strong> {{ $currentWeather->humidity }}%</li>
                <li class="list-group-item bg-light"><strong>Szerokość geograficzna:</strong> {{ number_format($currentWeather->latitude, 2) }}</li>
                <li class="list-group-item"><strong>Długość geograficzna:</strong> {{ number_format($currentWeather->longitude, 2) }}</li>
            </ul>
        </section>

        <section class="mt-5">
            <h2 class="h3 fw-semibold mb-4 text-center text-primary">📈 Wykresy pogody</h2>

            <div class="row g-5">
                <div class="col-12 col-md-6">
                    <div class="chart-container card p-4 shadow-sm rounded-4 bg-white" role="region" aria-label="Wykres temperatury">
                        <h3 class="h5 mb-3 text-center text-info">Temperatura (°C)</h3>
                        <canvas id="temperatureChart" aria-label="Wykres zmian temperatury" role="img"></canvas>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="chart-container card p-4 shadow-sm rounded-4 bg-white" role="region" aria-label="Wykres ciśnienia">
                        <h3 class="h5 mb-3 text-center text-warning">Ciśnienie (hPa)</h3>
                        <canvas id="pressureChart" aria-label="Wykres zmian ciśnienia" role="img"></canvas>
                    </div>
                </div>
                <div class="col-12 col-md-6 mx-auto">
                    <div class="chart-container card p-4 shadow-sm rounded-4 bg-white" role="region" aria-label="Wykres wilgotności">
                        <h3 class="h5 mb-3 text-center text-success">Wilgotność (%)</h3>
                        <canvas id="humidityChart" aria-label="Wykres zmian wilgotności" role="img"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            const historyData = @json($history);

            const formatDate = (date) => {
                const formattedDate = new Date(date);
                return formattedDate.toLocaleString('pl-PL', {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            };

            const labels = historyData.map(record => formatDate(record.recorded_at));
            const temperatureData = historyData.map(record => record.temperature);
            const pressureData = historyData.map(record => record.pressure);
            const humidityData = historyData.map(record => record.humidity);

            const createChart = (ctxId, label, data, color) => {
                const ctx = document.getElementById(ctxId).getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: label,
                            data: data,
                            borderColor: color,
                            backgroundColor: color + '33',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointHoverRadius: 7,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    font: { size: 14 }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Data'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: label
                                }
                            }
                        }
                    }
                });
            };

            createChart('temperatureChart', 'Temperatura (°C)', temperatureData, '#0dcaf0');
            createChart('pressureChart', 'Ciśnienie (hPa)', pressureData, '#ffc107');
            createChart('humidityChart', 'Wilgotność (%)', humidityData, '#198754');

            const toggleButton = document.getElementById('darkModeToggle');
            toggleButton.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
            });

            document.addEventListener('DOMContentLoaded', () => {
                if (localStorage.getItem('darkMode') === 'true') {
                    document.body.classList.add('dark-mode');
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .chart-container {
                min-height: 400px;
                background: linear-gradient(145deg, #ffffff, #f0f4f8);
            }
            canvas {
                width: 100% !important;
                height: 300px !important;
            }
            .list-group-item {
                font-size: 1.1em;
                color: #555;
                border: none;
            }

            a.btn:focus-visible {
                outline: 3px solid #0d6efd;
                outline-offset: 4px;
                border-radius: 0.75rem;
            }

            h1, h2, h3 {
                color: #2c3e50;
            }

            body {
                background-color: var(--background);
                color: var(--text-color);
                transition: background-color 0.3s, color 0.3s;
            }

            .card {
                background-color: var(--card-background);
                color: var(--text-color);
                border: none;
                border-radius: 1rem;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            }

            a:focus, button:focus, .btn:focus {
                outline: 3px solid #00bcd4;
                outline-offset: 2px;
                border-radius: 6px;
            }

            #temperatureChart, #pressureChart, #humidityChart {
                width: 100%;
                max-width: 700px;
                height: 350px;
                margin: 0 auto;
            }

            :root {
                --background: #ffffff;
                --text-color: #212529;
                --card-background: #f8f9fa;
            }

            body.dark-mode {
                --background: #121212;
                --text-color: #f1f1f1;
                --card-background: #1e1e1e;
            }

            .dark-mode-toggle {
                position: fixed;
                top: 1rem;
                right: 1rem;
                background: #00bcd4;
                color: #000000;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 2rem;
                font-size: 1rem;
                cursor: pointer;
                z-index: 1000;
            }
        </style>
    @endpush
@endsection
