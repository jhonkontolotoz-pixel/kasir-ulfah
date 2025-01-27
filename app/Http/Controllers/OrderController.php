<?php

namespace App\Http\Controllers;

use App\Events\OrderConfirmed;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\OrderFiltersRequest;
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

    public function index(OrderFiltersRequest $request)
    {
        $orders = Order::with(['customer:id,name','user:id,name'])
        ->withCount('products')
        ->when($request->status , function($q) use ($request){
            $q->where("status",$request->status);
        })
        ->when($request->payment , function($q) use ($request){
            $q->where("payment_method",$request->payment);
        })
        ->when($request->code , function($q) use ($request){
            $q->where('code','LIKE',"%{$request->code}%");
        })
        ->when($request->customer_name , function($q) use ($request){
            $q->whereHas("customer", function($query) use ($request) {
                $query->where("name","LIKE","%{$request->customer_name}%");
            });
        })
        ->when($request->sortBy && $request->order , function($q) use ($request){
            $q->orderBy($request->sortBy , $request->order);
        },function($q){
            $q->latest();
        })
        ->paginate($request->limit ?? 10);



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
