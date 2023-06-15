<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Advertiser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AdvertiserResource;
use App\Http\Controllers\Controller;

class AdvertiserController extends Controller
{
    public function index()
    {
        try {
            $advertisers = Advertiser::with('user')->get();
            return AdvertiserResource::collection($advertisers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'domain' => 'required',
                'firm' => 'required',
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'phone_number' => ['required', 'regex:/^0[67][0-9]{8}$/','unique:users'],
            ]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone_number' => $data['phone_number'],
                'role_id' => 4, 
            ]);

            $advertiser = Advertiser::create([
                'domain' => $data['domain'],
                'firm' => $data['firm'],
                'user_id' => $user->id,
            ]);

            return new AdvertiserResource($advertiser);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $advertiser = $request->user()->advertiser;
            if (!$advertiser) {
                return response()->json(['error' => 'Advertiser not found'], 404);
            }

            return new AdvertiserResource($advertiser);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
   
    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'domain' => 'required',
                'firm' => 'required',
            ]);
    
            $advertiser = $request->user()->advertiser;
            if (!$advertiser) {
                return response()->json(['error' => 'Advertiser not found'], 404);
            }
    
            $advertiser->update($data);
            return new AdvertiserResource($advertiser);
        } catch (\Exception $e) {
            // This will catch any exception, you might want to add additional catch blocks for more specific exceptions
            return response()->json(['error' => 'Unexpected error occurred. Please try again. check all fields or domain enums '], 500);
        }
    }
    
}
 