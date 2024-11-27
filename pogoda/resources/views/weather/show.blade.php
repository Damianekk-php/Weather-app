@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Szczegóły pogody dla: {{ $currentWeather->city_name }}</h1>

        <div>
            <h3>Aktualne dane:</h3>
            <ul>
                <li>Opis: {{ $currentWeather->description }}</li>
                <li>Temperatura: {{ $currentWeather->temperature }} °C</li>
                <li>Ciśnienie: {{ $currentWeather->pressure }} hPa</li>
                <li>Wilgotność: {{ $currentWeather->humidity }}%</li>
            </ul>
        </div>

        <div class="mt-5 chart-container">
            <h3>Temperatura</h3>
            <canvas id="temperatureChart"></canvas>
        </div>

        <div class="mt-5 chart-container">
            <h3>Ciśnienie</h3>
            <canvas id="pressureChart"></canvas>
        </div>

        <div class="mt-5 chart-container">
            <h3>Wilgotność</h3>
            <canvas id="humidityChart"></canvas>
        </div>

    </div>

    @push('scripts')
        <script>
            const historyData = @json($history);

            // Formatowanie daty - użyj moment.js (jeśli masz ją załadowaną)
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

            console.log(historyData);

            const labels = historyData.map(record => formatDate(record.recorded_at));  // Formatowana data
            const temperatureData = historyData.map(record => record.temperature);
            const pressureData = historyData.map(record => record.pressure);
            const humidityData = historyData.map(record => record.humidity);

            // Temperatura
            const tempCtx = document.getElementById('temperatureChart').getContext('2d');
            new Chart(tempCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Temperatura (°C)',
                        data: temperatureData,
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'category',
                            title: { display: true, text: 'Data' }
                        },
                        y: {
                            title: { display: true, text: 'Temperatura (°C)' }
                        }
                    }
                }
            });

            // Ciśnienie
            const pressureCtx = document.getElementById('pressureChart').getContext('2d');
            new Chart(pressureCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ciśnienie (hPa)',
                        data: pressureData,
                        borderColor: 'rgb(54, 162, 235)',
                        fill: false,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'category',
                            title: { display: true, text: 'Data' }
                        },
                        y: {
                            title: { display: true, text: 'Ciśnienie (hPa)' }
                        }
                    }
                }
            });

            // Wilgotność
            const humidityCtx = document.getElementById('humidityChart').getContext('2d');
            new Chart(humidityCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Wilgotność (%)',
                        data: humidityData,
                        borderColor: 'rgb(75, 192, 192)',
                        fill: false,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'category',
                            title: { display: true, text: 'Data' }
                        },
                        y: {
                            title: { display: true, text: 'Wilgotność (%)' }
                        }
                    }
                }
            });
        </script>
    @endpush
    @push('styles')
        <style>
            /* Style dla wykresów */
            #temperatureChart,
            #pressureChart,
            #humidityChart {
                width: 100%; /* Ustawia wykresy na 100% szerokości kontenera */
                max-width: 700px; /* Maksymalna szerokość wykresów */
                height: 350px; /* Wysokość wykresów */
                margin: 0 auto; /* Wyśrodkowanie wykresów */
            }
        </style>
    @endpush
@endsection
