<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'register'], // Tambahkan login & register jika route-nya tidak pakai prefix api

'allowed_methods' => ['*'],

// JANGAN gunakan ['*']. Masukkan URL frontend kamu secara spesifik.
'allowed_origins' => [
    'http://localhost:5173', 
    'http://127.0.0.1:5173',
    'http://localhost:3000' // Sesuaikan dengan port yang kamu pakai di Vue
],

'allowed_origins_patterns' => [],

'allowed_headers' => ['*'],

'exposed_headers' => [],

'max_age' => 0,

'supports_credentials' => true, // Ini sudah benar, tapi butuh allowed_origins yang spesifik

];