<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 3600,
            'user' => ['firstName' => auth()->user()->first_name, 'lastName' => auth()->user()->last_name],
        ]);
    }

    public function user()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}
