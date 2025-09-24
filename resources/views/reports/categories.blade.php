@extends("reports.layouts.pdf-portrait-layout")
@section('content')

<table cellspacing="0" border="0">
    <tr class="t-head">
        <th>No</th>
        <th>Name</th>
        <th>Products</th>
        <th>Created At</th>
    </tr>
    @php($alt = false)
    @foreach($categories as $category)
    <tr class="t-body {{ $alt ? 'alt-color' : 'native-color' }}">
        <td>{{($loop->index + 1)}}</td>
        <td>{{$category['name']}}</td>
        <td>{{$category['products_count']}}</td>
        <td>{{$category['created_at']}}</td>
    </tr>
    @php($alt = !$alt)
    @endforeach
</table>

@endsection