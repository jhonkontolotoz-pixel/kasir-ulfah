<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        if (Auth::check()) {

            $request->session()->regenerate();

            $token = auth()->user()->createToken('Token')->plainTextToken;

            return simpleSuccessResponse($token);
        }
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required',  Password::defaults()],
        ]);

        $token = "";

        DB::transaction(function () use ($request, &$token) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);


            $user->assignRole("admin");

            Auth::login($user);

            $token = auth()->user()->createToken($request->email)->plainTextToken;
        });


        return response()->json(['message' => 'user registerd successfully', 'token' => $token], 200);
    }
}
