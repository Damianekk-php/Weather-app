<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Miasta</title>
</head>
<body>
<h1>Lista miast</h1>
<form action="{{ route('cities.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nazwa miasta">
    <input type="text" name="api_city_id" placeholder="ID miasta w API">
    <button type="submit">Dodaj miasto</button>
</form>
<ul>
    @foreach ($cities as $city)
        <li>
            {{ $city->name }}
            <form action="{{ route('cities.destroy', $city) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Usuń</button>
            </form>
        </li>
    @endforeach
</ul>
</body>
</html>
