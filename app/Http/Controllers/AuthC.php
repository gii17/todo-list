<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthC extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string',
            "username" => 'required|string',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        return $this->sendResponse($user,200,"User registered successfully!");
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('username', 'password'))) {
            return $this->sendResponse(false, 401,"Invalid credentials!");
        }

        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return $this->sendResponse([
            'token' => $token,
            'name'  => $user->name,
            "email" => $user->email,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendResponse(true,200,"Logged out successfully");
    }
}
