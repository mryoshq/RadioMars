<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Advertiser;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'firm' => 'required|string|max:255',
            'domain' => 'required|string|max:255',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);
    
        $advertiser = Advertiser::create([
            'user_id' => $user->id,
            'firm' => $request->firm,
            'domain' => $request->domain,
        ]);
    
        return response()->json([
            'message' => 'Registration successful.',
            'user' => $user,
            'advertiser' => $advertiser,
            'token' => $user->createToken('appToken')->plainTextToken,
        ], 201);
    }
    
    
    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);
    
        $user = User::where('phone_number', $request->phone_number)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone_number' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'advertiser' => $user->advertiser, 
            'token' => $user->createToken('appToken')->plainTextToken,
        ], 200);
    }
     
    
    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
