<?php

namespace App\Http\Controllers;

use App\Http\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        return successResponse(DashboardService::counts($request));
    }

    public function salesChart(Request $request)
    {
        return successResponse(DashboardService::salesChart($request));
    }

    public function ordersStatusChart()
    {
        return successResponse(DashboardService::ordersStatusChart());
    }

    public function revenueChart(Request $request)
    {
        return successResponse(DashboardService::revenueChart($request));
    }

    public function latestOrders(Request $request)
    {
        return successResponse(DashboardService::counts($request));
    }

    public function latestProducts(Request $request)
    {
        return successResponse(DashboardService::counts($request));
    }
  

}