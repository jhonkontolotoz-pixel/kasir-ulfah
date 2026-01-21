<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- Routes Private (Wajib Login) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // User Info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Dashboard & Charts
    Route::get('/counts', [DashboardController::class, 'index']); // <-- WAJIB ADA UNTUK Dashboard.vue
    Route::get('/salesChart', [DashboardController::class, 'salesChart']);
    Route::get('/ordersStatusChart', [DashboardController::class, 'ordersStatusChart']);
    Route::get('/revenueChart', [DashboardController::class, 'revenueChart']);
    Route::get('/topProducts', [DashboardController::class, 'topProducts']);

    // Reports
    Route::prefix('reports')->group(function () {
        Route::get('/categories/{key}', [ReportController::class, 'categoriesReport']);
        Route::get('/products/{key}', [ReportController::class, 'productsReport']);
        Route::get('/orders/{key}', [ReportController::class, 'ordersReport']);
        Route::get('/customers/{key}', [ReportController::class, 'customersReport']);
        Route::get('/receipt/{key}', [ReportController::class, 'receipt']);
    });

    // Resources & Search
    Route::get('/customers/search/pos', [CustomerController::class, 'searchPOS']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('orders', OrderController::class);

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

// --- Routes Public (Auth) ---
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/register', [RegisteredUserController::class, 'store']);

// Language Switcher
Route::post('/setLang', function (Request $request) {
    App::setLocale($request->_lang);
});