<?php

namespace App\Http\Services;

use App\Http\Resources\Dashboard\TopProductsResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;

class DashboardService
{

    public static function counts($request = null)
    {
        $usersCount     = User::count();
        $customersCount = Customer::count();
        $productsCount  = Product::count();
        $ordersCount    = Order::whereNot('status', 'canceled')->count();
        $revenue        = Order::whereNot('status', 'canceled')->sum('total_price');
        return [
            'users_count'     => $usersCount,
            'customers_count' => $customersCount,
            'products_count'  => $productsCount,
            'orders_count'    => intval(number_format($ordersCount,2)),
            'revenue'         => number_format($revenue,2)
        ];
    }


    public static function salesChart($request = null)
    {

        $date_from = $request && $request->date_from ? Carbon::parse($request->date_from)->toDateTimeString() : Carbon::now()->startOfMonth();
        $date_to = $request && $request->date_to ? Carbon::parse($request->date_to)->endOfDay()->toDateTimeString() : Carbon::now();
 
        $format = "%d/%m";

        if ($request->type && $request->type == 'yearly') {
            $format = "%Y";
        } elseif ($request->type && $request->type == 'monthly') {
            $format = "%b %Y";
        } elseif ($request->type && $request->type == 'weekly') {
            $format = "%U";
        }

        $orders = Order::query()
        ->when($request->date_from && $request->date_to , function($query) use ($date_from,$date_to){
            $query->whereBetween("orders.created_at", [$date_from, $date_to]);
        })
            ->whereNot("orders.status", "cancelled")
            ->select(
                DB::raw("DATE_FORMAT(orders.created_at,'$format') as date"),
                DB::raw('COUNT(orders.id) as orders_count'),
                DB::raw('FORMAT(SUM(orders.total_price), 2) as revenue'),
                DB::raw('CAST(SUM(orders.total_price)/COUNT(orders.id) AS DECIMAL(8,2)) as orders_avg'),
            )
            ->groupBy(DB::raw("DATE_FORMAT(orders.created_at,'$format')"))
            ->orderBy(DB::raw("DATE_FORMAT(orders.created_at,'$format')"))
            ->get();

            
        return [
            'labels'  => $orders->map->date,
            'datasets' =>  $orders->map->orders_count
        ];
    }

    public static function revenueChart($request = null)
    {

        $date_from = $request && $request->date_from ? Carbon::parse($request->date_from)->toDateTimeString() : Carbon::now()->startOfMonth();
        $date_to = $request && $request->date_to ? Carbon::parse($request->date_to)->endOfDay()->toDateTimeString() : Carbon::now();
 
        $format = "%d/%m";

        if ($request->type && $request->type == 'yearly') {
            $format = "%Y";
        } elseif ($request->type && $request->type == 'monthly') {
            $format = "%b %Y";
        } elseif ($request->type && $request->type == 'weekly') {
            $format = "%U";
        }

        $orders = Order::query()
        ->when($request->date_from && $request->date_to , function($query) use ($date_from,$date_to){
            $query->whereBetween("orders.created_at", [$date_from, $date_to]);
        })
            ->whereNot("orders.status", "cancelled")
            ->select(
                DB::raw("DATE_FORMAT(orders.created_at,'$format') as date"),
                DB::raw('CAST(SUM(orders.total_price) AS DECIMAL(10, 2)) as revenue')
            )
            ->groupBy(DB::raw("DATE_FORMAT(orders.created_at,'$format')"))
            ->orderBy(DB::raw("DATE_FORMAT(orders.created_at,'$format')"))
            ->get();

            
        return [
            'labels'  => $orders->map->date,
            'datasets' =>  $orders->map->revenue
        ];
    }


    
    public static function ordersStatusChart()
    {

        $orders = Order::select(DB::raw('COUNT(id) as orders_count'),'status')->groupBy("status")->get();

        return [
            'labels'  => $orders->map->status,
            'datasets' =>  $orders->map->orders_count
        ];
    }



    public static function ordersChart($request = null)
    {
        $date_from = $request && $request->date_from ? Carbon::parse($request->date_from)->toDateTimeString() : Carbon::now()->startOfMonth();
        $date_to = $request && $request->date_to ? Carbon::parse($request->date_to)->endOfDay()->toDateTimeString() : Carbon::now();

        $format = "%d/%m";
        if ($request->type && $request->type == 'yearly') {
            $format = "%Y";
        } elseif ($request->type && $request->type == 'monthly') {
            $format = "%b %Y";
        } elseif ($request->type && $request->type == 'weekly') {
            $format = "%U";
        }

        $orders = Order::whereBetween("orders.created_at", [$date_from, $date_to])
            ->whereNot("orders.status", "cancelled")
            ->select(
                DB::raw("DATE_FORMAT(orders.created_at,'$format') as date"),
                DB::raw('COUNT(orders.id) as orders_count'),
                DB::raw('SUM(orders.total_price) as revenue'),
                DB::raw('CAST(SUM(orders.total_price)/COUNT(orders.id) AS DECIMAL(8,2)) as orders_avg'),
            )
            ->groupBy(DB::raw("DATE_FORMAT(orders.created_at,'$format')"))
            ->orderBy("orders.created_at")
            ->get();

        return $orders;
    }

    public static function topProducts()
    {
        $productsCount = Product::with('images')->select(
        DB::raw("products.id"),
        DB::raw("products.title"),
        DB::raw('SUM(order_products.quantity) as sold_count'),
        )
        ->join("order_products","order_products.product_id","products.id")
        ->groupBy("products.id","products.title","products.sku")
        ->orderByDesc("sold_count")
        ->get()
        ->take(5);

        return TopProductsResource::collection($productsCount);
    }

}
