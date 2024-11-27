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
                                <option value="{{ $city->id }}"
                                        @if (in_array($city->id, $cityIds)) selected @endif>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Wybierz do 10 miast, z których chcesz pobierać dane pogodowe.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg mt-3">Zapisz ustawienia</button>
                </form>

                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
