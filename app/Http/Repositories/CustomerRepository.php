<?php

namespace App\Http\Repositories;

use App\Http\Resources\Customer\CustomersCollection;
use App\Http\Resources\Product\ProductCollection;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CustomerRepository
{

    public function __construct(private Product $model) {}


    public function findAll($request)
    {
        $page = $request->get('page', 1);

        $key = "customers." . md5(http_build_query($request->all() + ['page' => $page]));

        $customers = Cache::remember($key, 60, function () use ($request) {

            $customers = Customer::withCount('orders')
                ->when($request->name, function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%{$request->name}%");
                })
                ->when($request->phone, function ($q) use ($request) {
                    $q->where('phone', 'LIKE', "%{$request->phone}%");
                })
                ->when($request->email, function ($q) use ($request) {
                    $q->where('email', 'LIKE', "%{$request->email}%");
                })
                ->when($request->sortBy && $request->order, function ($q) use ($request) {
                    $q->orderBy($request->sortBy, $request->order);
                }, function ($q) {
                    $q->latest();
                })
                ->paginate($request->limit ?? 10);

            return new CustomersCollection($customers);
        });

        return [$customers, $key];
    }

}
