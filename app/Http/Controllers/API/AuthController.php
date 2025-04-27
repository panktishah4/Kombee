<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);
        $http = Http::asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type'    => 'password',
            'client_id'     => config('services.passport.password_client_id'),
            'client_secret' => config('services.passport.password_client_secret'),
            'username'      => $request->email,
            'password'      => $request->password,
            'scope'         => ''
        ]);

        if ($http->failed()) {
            return response()->json(['error' => 'Invalid credentials or token request failed'], 401);
        }
        return $http->json();
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
