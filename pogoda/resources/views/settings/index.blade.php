@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Ustawienia Miast</h1>

        <div class="card">
            <div class="card-header">
                <h4>Wybierz miasta do pobierania pogody</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="cities">Wybierz miasta:</label>
                        <select name="city_ids[]" id="cities" class="form-control" multiple>
                            @foreach ($cities as $city)
                                @if (!in_array($city->id, $cityIds))
                                    <option value="{{ $city->id }}">
                                        {{ $city->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Wybierz do 10 miast, z których chcesz pobierać dane pogodowe.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg mt-3">Zapisz ustawienia</button>
                </form>

                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('weather.index') }}" class="btn btn-secondary btn-lg mt-3">Przejdź do Pogody</a>
            </div>
        </div>
    </div>
@endsection
