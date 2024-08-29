@foreach($restaurants as $restaurant)
    <tr>
        <td><input type="checkbox" class="form-check-input" value="{{ $restaurant->id }}" data-name="{{ $restaurant->name }}" data-img="{{ $restaurant->avatar }}"></td>
        <td>{{ $restaurant->id }}</td>
        <td><img class="rounded" src="{{ $restaurant->avatar ?? asset('images/noimage.jpg') }}" width="50" height="50" alt="{{ $restaurant->name }}"></td>
        <td>{{ $restaurant->name }}</td>
    </tr>
@endforeach

<div id="pagination-links">
    {{ $restaurants->links() }}
</div>
