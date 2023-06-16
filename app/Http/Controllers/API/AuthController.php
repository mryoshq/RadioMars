<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        // Auto login after registration
        Auth::attempt($request->only('email', 'password'));

        return response()->json([
            'message' => 'Successfully registered!',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        return response()->json([
            'message' => 'Successfully logged in',
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
