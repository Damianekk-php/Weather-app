<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ustawienia miast</title>
</head>
<body>
<h1>Ustawienia miast</h1>
<form method="POST" action="{{ route('cities.update') }}">
    @csrf
    <table>
        <thead>
        <tr>
            <th>Miasto</th>
            <th>ID API</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($cities as $city)
            <tr>
                <td><input type="text" name="cities[{{ $loop->index }}][name]" value="{{ $city->name }}" required></td>
                <td><input type="text" name="cities[{{ $loop->index }}][api_city_id]" value="{{ $city->api_city_id }}" required></td>
            </tr>
        @endforeach
        @for ($i = count($cities); $i < 10; $i++)
            <tr>
                <td><input type="text" name="cities[{{ $i }}][name]" placeholder="Miasto" required></td>
                <td><input type="text" name="cities[{{ $i }}][api_city_id]" placeholder="ID API" required></td>
            </tr>
        @endfor
        </tbody>
    </table>
    <button type="submit">Zapisz</button>
</form>
</body>
</html>
