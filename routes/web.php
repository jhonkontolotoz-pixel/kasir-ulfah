<?php

use Illuminate\Support\Facades\Route;

// Biarkan Sanctum menangani CSRF cookie secara internal
// Route::get('/sanctum/csrf-cookie', ...) -> Ini sudah otomatis ada dari package

// Tangkap semua URL dan arahkan ke file app.blade.php (Vue)
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');