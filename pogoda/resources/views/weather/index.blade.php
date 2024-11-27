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
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th>Miasto</th>
                        <th>Temperatura</th>
                        <th>Wilgotność</th>
                        <th>Akcja</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($weathers as $weather)
                        <tr>
                            <td>
                                @if ($weather->city_name)
                                    {{ $weather->city_name }}
                                @else
                                    <em>Brak miasta</em>
                                @endif
                            </td>
                            <td>{{ $weather->temperature }} °C</td>
                            <td>{{ $weather->humidity }}%</td>
                            <td>
                                <a href="{{ route('weather.show', $weather->city_id) }}" class="btn btn-info btn-sm">Szczegóły</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>
@endsection
