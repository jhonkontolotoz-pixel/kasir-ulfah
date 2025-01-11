<?php

namespace App\Http\Controllers;

use App\Events\OrderConfirmed;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\OrderStatusUpdateRequest;
use App\Http\Resources\Order\OrdersCollection;
use App\Http\Resources\Order\OrdersResource;
use App\Http\Services\OrderService;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orders = Order::with(['customer:id,name','user:id,name'])->withCount('orderItems')->latest()->paginate($request->limit ?? 10);

        return successResponse(new OrdersCollection($orders));
    }

    public function show(Order $order)
    {
        return successResponse(new OrdersResource($order->loadCount('products')->load(['products','user:id,name','customer:id,name'])));
    }

    public function store(OrderRequest $request)
    {

        OrderService::CreateOrder($request->validated());
        
        return successResponse(message: "Order Created Successfully");

    }

    public function updateOrderStatus(OrderStatusUpdateRequest $request , Order $order)
    {
        $order->update(['status' => $request->validated()]);

        return successResponse(message: "Order Updated Successfully");

    }

    public function destroy( Order $order)
    {
        $order->delete();

        return successResponse(message: "Order Deleted Successfully");

    }



}
