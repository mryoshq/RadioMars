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
        try {
            $customMessages = [
                'required' => 'The :attribute field is required.',
                'unique' => 'The :attribute has already been taken.',
                'min' => [
                    'string'  => 'The :attribute must be at least :min characters.',
                ],
                'max' => [
                    'string'  => 'The :attribute may not be greater than :max characters.',
                ],
                'email' => 'The :attribute must be a valid email address.'
            ];
    
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => 'required|string|max:20|unique:users',
                'password' => 'required|string|min:8',
                'firm' => 'required|string|max:255',
                'domain' => 'required|string|max:255',
            ], $customMessages);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role_id' => 4,
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
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Registration failed.',
                'errors' => $e->getMessage()
            ], 400);
        }
    }
    
    
    
    
    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json([
                'message' => 'The provided phone number does not belong to any user.',
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided password is incorrect.',
            ], 403);
        }

        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'advertiser' => $user->advertiser,
            'token' => $user->createToken('appToken')->plainTextToken,
        ], 200);
    }

     
    
    public function logout(Request $request)
    {
        // Revoke the user's current token...
        $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    
}
