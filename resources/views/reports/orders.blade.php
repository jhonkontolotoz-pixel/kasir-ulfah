@extends("reports.layouts.pdf-portrait-layout")
@section('content')

<table cellspacing="0" border="0">
    <tr class="t-head">
        <th width="5%">No</th>
        <th width="6%">Code</th>
        <th>Customer</th>
        <th>Payment</th>
        <th>Status</th>
        <th width="6%">Items</th>
        <th width="6%">Total</th>
        <th>Shipped At</th>
        <th>Delivered At</th>
        <th>Created At</th>
    </tr>
    @php($alt = false)
    @foreach($orders as $order)
    <tr class="t-body {{ $alt ? 'alt-color' : 'native-color' }}">
        <td>{{($loop->index + 1)}}</td>
        <td>{{$order['code']}}</td>
        <td>{{$order['customer_name']}}</td>
        <td>{{$order['payment_method']}}</td>
        <td>{{$order['status']}}</td>
        <td>{{$order['products_count']}}</td>
        <td>{{$order['total']}}</td>
        <td>{{$order['shipped_at']}}</td>
        <td>{{$order['delivered_at']}}</td>
        <td>{{$order['created_at']}}</td>
    </tr>
    @php($alt = !$alt)
    @endforeach
</table>

@endsection