@foreach ($restaurants as $restaurant)
<tr>
    <td><input type="radio" name="restaurant_id" value="{{ $restaurant->id }}"></td>
    <td>{{ $restaurant->name }}</td>
</tr>
@endforeach