<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get("reports/categories/{key}",[ReportController::class , 'categoriesReport']);
    Route::get("reports/products/{key}",[ReportController::class , 'productsReport']);
    Route::get("reports/orders/{key}",[ReportController::class , 'ordersReport']);
    Route::get("reports/categories/{key}",[ReportController::class , 'categoriesReport']);
    Route::get("reports/customers/{key}",[ReportController::class , 'customersReport']);
    Route::get("reports/receipt/{key}",[ReportController::class , 'receipt']);

});
    
Route::get('{any}', function () {
    return view('app');
})->where('any' , '.*');
