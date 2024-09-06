@foreach ($products as $product)
<tr>
    <td><input type="radio" name="product_id" value="{{ $product->id }}"></td>
    <td>{{ $product->name }}</td>
</tr>
@endforeach