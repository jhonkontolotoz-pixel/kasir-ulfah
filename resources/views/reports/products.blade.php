@extends("reports.layouts.pdf-portrait-layout")
@section('content')

<table cellspacing="0" border="0">
    <tr class="t-head">
        <th width="3%">No</th>
        <th>SKU</th>
        <th>Title</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Category</th>
        <th>Created At</th>
    </tr>
    @php($alt = false)
    @foreach($products as $product)
    <tr class="t-body {{ $alt ? 'alt-color' : 'native-color' }}">
        <td>{{($loop->index + 1)}}</td>
        <td>{{$product['sku']}}</td>
        <td>{{$product['title']}}</td>
        <td>{{$product['price']}}</td>
        <td>{{$product['quantity']}}</td>
        <td>{{$product['category_name']}}</td>
        <td>{{$product['created_at']}}</td>
    </tr>
    @php($alt = !$alt)
    @endforeach
</table>

@endsection