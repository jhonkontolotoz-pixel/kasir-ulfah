<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
     /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        if (Auth::check()) {

            $request->session()->regenerate();

            //$token = auth()->user()->createToken('Token')->plainTextToken;

            return simpleSuccessResponse(['user' => collect([
                'name' => auth()->user()->name
            ])]);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth()->user()->tokens()->delete();

        Auth::logout();

        return simpleSuccessResponse(message:"logged out");
       
    }
}
