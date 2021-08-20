<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $user = User::create($request->validated());
        return response()->json($user,201);
    }

    public function login(LoginRequest $request) {
        if (Auth::attempt($request->validated())) {
            $user = User::where('email', $request->email)->first();
            return response()->json($user,200);
        }
        return response()->json("Wrong auth data", \Illuminate\Http\Response::HTTP_FORBIDDEN);
    }

    public function logout() {
        Auth::user()->currentAccessToken()->delete();
        return response()-> json("You have been successfully logged out",200);
    }
}
