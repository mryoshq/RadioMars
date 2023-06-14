<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Advertiser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdvertiserController extends Controller
{
    
    public function index()
    {
        $advertisers = Advertiser::with('user')->get();
    
        return view('advertisers.index', compact('advertisers'));
    }
    

 
    public function create()
    {
        return view('advertisers.create');
    }

   
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'domain' => 'required',
            'firm' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone_number' => ['required', 'regex:/^0[67][0-9]{8}$/','unique:users'],
        ]);
    
        // Create a new User with the 'Advertiser' role
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'role_id' => 4, //  for Advertisers
        ]);
    
        // Create a new Advertiser using the newly created User's id
        Advertiser::create([
            'domain' => $data['domain'],
            'firm' => $data['firm'],
            'user_id' => $user->id,
        ]);
    
        // Redirect the user back with a success message
        return redirect()->route('advertisers.index')->with('success', 'Advertiser created successfully');
    }

  
    public function show(Advertiser $advertiser)
    {
        return view('advertisers.show', compact('advertiser'));
    }

   
    public function edit(Advertiser $advertiser)
    {
        return view('advertisers.edit', compact('advertiser'));
    }

   
    public function update(Request $request, Advertiser $advertiser)
    {
        $data = $request->validate([
            'domain' => 'required',
            'firm' => 'required',
            'user_id' => 'required',
        ]);

        $advertiser->update($data);

        return redirect()->route('advertisers.index');
    }

    public function destroy(Advertiser $advertiser)
    {
        $advertiser->delete();

        return redirect()->route('advertisers.index');
    }
}
