<form action="{{ route('cities.select') }}" method="POST">
    @csrf
    <select name="city_id">
        @foreach($cities as $city)
            <option value="{{ $city->id }}" {{ in_array($city->id, $userSelections) ? 'selected' : '' }}>
                {{ $city->name }} ({{ $city->country }})
            </option>
        @endforeach
    </select>
    <button type="submit">Zapisz</button>
</form>
