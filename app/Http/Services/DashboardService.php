<?php

namespace App\Http\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardService
{

    public static function counts($request)
    {
        $usersCount     = User::count();
        $customersCount = Customer::count();
        $productsCount  = Product::count();
        $ordersCount    = Order::whereNot('status', 'canceled')->count();

        return [
            'users_count'     => $usersCount,
            'customers_count' => $customersCount,
            'products_count'  => $productsCount,
            'orders_count'    => $ordersCount
        ];
    }


    public static function revenue($request)
    {
        return [];
    }

}
