<?php

namespace App\Http\Repositories;

use App\Http\Resources\Customer\CustomersCollection;
use App\Http\Resources\Order\OrdersCollection;
use App\Http\Resources\Product\ProductCollection;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class OrderRepository
{

    public function __construct(private Product $model) {}


    public function findAll($request)
    {
        $page = $request->get('page', 1);

        $key = "orders." . md5(http_build_query($request->all() + ['page' => $page]));

        $orders =  Cache::remember($key, 60, function () use ($request) {

            $orders = Order::with(['customer:id,name', 'user:id,name'])
                ->withCount('products')
                ->when($request->status, function ($q) use ($request) {
                    $q->where("status", $request->status);
                })
                ->when($request->payment, function ($q) use ($request) {
                    $q->where("payment_method", $request->payment);
                })
                ->when($request->code, function ($q) use ($request) {
                    $q->where('code', 'LIKE', "%{$request->code}%");
                })
                ->when($request->customer_name, function ($q) use ($request) {
                    $q->whereHas("customer", function ($query) use ($request) {
                        $query->where("name", "LIKE", "%{$request->customer_name}%");
                    });
                })
                ->when($request->sortBy && $request->order, function ($q) use ($request) {
                    $q->orderBy($request->sortBy, $request->order);
                }, function ($q) {
                    $q->latest();
                })
                ->paginate($request->limit ?? 10);

            return new OrdersCollection($orders);
        });

        return [$orders, $key];
    }

}
