<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


use Illuminate\Support\Facades\App;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
   
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('orders', OrderController::class);
    Route::get('counts',[DashboardController::class , 'index']);
    Route::get('salesChart',[DashboardController::class , 'salesChart']);
    Route::get('ordersStatusChart',[DashboardController::class , 'ordersStatusChart']);
    Route::get('revenueChart',[DashboardController::class , 'revenueChart']);
    Route::get('topProducts',[DashboardController::class , 'topProducts']);
   
});

Route::post("/login", [AuthenticatedSessionController::class, 'store']);
Route::post('/setLang', function (Request $request) {

    App::setLocale($request->_lang);
});

