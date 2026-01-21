<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
public function store(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
    ]);

    try {
        // 2. Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        // 3. Assign role (pastikan package Spatie sudah terinstall & role 'customer' ada)
        if (method_exists($user, 'assignRole')) {
            // Kita pakai try-catch kecil di sini agar jika role belum dibuat di DB, 
            // user-nya tetap berhasil register tapi tidak error 500/404
            try {
                $user->assignRole('customer');
            } catch (\Exception $e) {
                // Log error jika role tidak ditemukan
                \Illuminate\Support\Facades\Log::error("Role customer tidak ditemukan: " . $e->getMessage());
            }
        }

        // 4. Login otomatis
        //\Illuminate\Support\Facades\Auth::login($user);

        // 5. Buat token
        $token = $user->createToken('API Token')->plainTextToken;

        // RESPONSE HARUS JSON (Ini yang bikin Vue kamu sukses masuk ke blok 'try')
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user, // Kita kirim data user-nya
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Registration failed: ' . $e->getMessage(),
        ], 500);
    }
}

}