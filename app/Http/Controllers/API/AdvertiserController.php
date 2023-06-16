<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Advertiser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AdvertiserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class AdvertiserController extends Controller
{
    /*
    public function index()
    {
        try {
            $advertisers = Advertiser::with('user')->get();
            return AdvertiserResource::collection($advertisers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    */
    
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
    
            $advertiser->load('user');  // load the user data
            $advertiser->load('ads');
            $advertiser->load('payments');
    
            return new AdvertiserResource($advertiser);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    
   
    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'domain' => 'required|in:artisanal1,artisanal2,artisanal3,artisanal4,artisanal5,artisanal6,artisanal7,artisanal8,artisanal9,artisanal10',
                'firm' => 'required|string|max:40',
                'user.name' => ['required', 'string', 'max:255'],
                'user.email' => ['required', 'string', 'email', 'max:255'],
                'user.phone_number' => ['required', 'regex:/^\+?[0-9]{11,15}$/'],
            ]);
    
            $advertiser = $request->user()->advertiser;
            if (!$advertiser) {
                return response()->json(['error' => 'Advertiser not found'], 404);
            }
    
            DB::beginTransaction();
    
            $advertiser->update([
                'domain' => $data['domain'],
                'firm' => $data['firm'],
            ]);
    
            $advertiser->user->update($data['user']);
    
            DB::commit();
    
            $advertiser->load('user');
    
            return new AdvertiserResource($advertiser);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    
    
}
 