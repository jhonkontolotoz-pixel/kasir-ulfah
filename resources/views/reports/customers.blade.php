@extends("reports.layouts.pdf-portrait-layout")
@section('content')

<table cellspacing="0" border="0">
    <tr class="t-head">
        <th width="5%">No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th width="5%">Orders</th>
        <th>Created At</th>
    </tr>
    @php($alt = false)
    @foreach($customers as $customer)
    <tr class="t-body {{ $alt ? 'alt-color' : 'native-color' }}">
        <td>{{($loop->index + 1)}}</td>
        <td>{{$customer['name']}}</td>
        <td>{{$customer['email']}}</td>
        <td>{{$customer['phone']}}</td>
        <td>{{$customer['address']}}</td>
        <td>{{$customer['orders_count']}}</td>
        <td>{{$customer['created_at']}}</td>
    </tr>
    @php($alt = !$alt)
    @endforeach
</table>

@endsection