<?php

namespace App\Http\Controllers;

use App\Http\Repositories\OrderRepository;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\OrderFiltersRequest;
use App\Http\Requests\Order\OrderStatusUpdateRequest;
use App\Http\Resources\Order\OrdersResource;
use App\Http\Services\OrderService;
use App\Models\Order;


class OrderController extends Controller
{
    public function __construct(public OrderRepository $orderRepository ) {}

    public function index(OrderFiltersRequest $request)
    {

        [$orders, $key] = $this->orderRepository->findAll($request);

        return successResponse($orders, additional: ['pdf_url' => url('reports/orders/' . $key)]);
    }

    public function show(Order $order)
    {
        return successResponse(new OrdersResource($order->loadCount('products')->load(['products', 'user:id,name', 'customer:id,name'])));
    }

    public function store(OrderRequest $request)
    {

        OrderService::CreateOrder($request->validated());

        return successResponse(message: "Order Created Successfully");
    }

    public function updateOrderStatus(OrderStatusUpdateRequest $request, Order $order)
    {
        $order->update(['status' => $request->validated()]);

        return successResponse(message: "Order Updated Successfully");
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return successResponse(message: "Order Deleted Successfully");
    }
}
