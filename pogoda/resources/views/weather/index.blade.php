@extends('layouts.app')

@section('content')
    <h1>Aktualna Pogoda</h1>

    <!-- Dodanie przycisku do przejścia na stronę ustawień -->
    <p><a href="{{ route('settings.index') }}" class="btn btn-secondary">Przejdź do ustawień miast</a></p>

    @if ($weathers->isEmpty())
        <p>Brak danych pogodowych. Proszę spróbować później.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Miasto</th>
                <th>Temperatura</th>
                <th>Warunki</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($weathers as $weather)
                <tr>
                    <td>
                        @if ($weather->city)
                            {{ $weather->city->name }}
                        @else
                            Brak miasta
                        @endif
                    </td>
                    <td>{{ $weather->temperature }} °C</td>
                    <td>{{ $weather->condition }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
