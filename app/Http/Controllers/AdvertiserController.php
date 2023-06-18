<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Advertiser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;


class AdvertiserController extends Controller
{
    
    public function index()
    {
        $advertisers = Advertiser::with('user')->get();
    
        return view('web.advertisers.index', compact('advertisers'));
    }
    

    public function create()
    {
        $advertiser = new Advertiser();
        $roles = Role::all();
        $domains = Advertiser::getDomainEnumValues(); 
        return view('web.advertisers.create', compact('advertiser', 'roles', 'domains'));
    }
    
    
    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        'phone_number' => ['required', 'regex:/^0[67][0-9]{8}$/', 'unique:users'],
        'firm' => ['required', 'string', 'max:40'],
        'domain' => ['required', 'in:artisanal1,artisanal2,artisanal3,artisanal4,artisanal5,artisanal6,artisanal7,artisanal8,artisanal9,artisanal10'],
    ]);

    // Create a new User with the 'Advertiser' role
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone_number' => $request->phone_number,
        'role_id' => 4, // for Advertisers
    ]);

    // Create a new Advertiser using the newly created User's id
    Advertiser::create([
        'domain' => $request->domain,
        'firm' => $request->firm,
        'user_id' => $user->id,
    ]);

    // Redirect the user back with a success message
    return redirect()->route('web.advertisers.index')->with('success', 'Advertiser created successfully');
}

    
  
    public function show(Advertiser $advertiser)
    {
        return view('web.advertisers.show', compact('advertiser'));
    }

   
    public function edit(Advertiser $advertiser)
    {
        $user = $advertiser->user;
        $domains = ['artisanal1', 'artisanal2', 'artisanal3', 'artisanal4', 'artisanal5', 'artisanal6', 'artisanal7', 'artisanal8', 'artisanal9', 'artisanal10'];

        return view('web.advertisers.edit', compact('advertiser', 'user', 'domains'));
    }
    
   
    public function update(Request $request, Advertiser $advertiser)
    {
        $data = $request->validate([
            'domain' => 'required',
            'firm' => 'required',
            'user_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$advertiser->user->id],
            'phone_number' => ['required', 'regex:/^0[67][0-9]{8}$/', 'unique:users,phone_number,'.$advertiser->user->id],
        ]);
    
        if($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
    
        $advertiser->update([
            'domain' => $data['domain'],
            'firm' => $data['firm'],
        ]);
     
        $advertiser->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => $data['password'] ?? $advertiser->user->password,
        ]);
    
        return redirect()->route('web.advertisers.index')->with('success', 'Advertiser updated successfully.');
    }
    

    public function destroy(Advertiser $advertiser)
    {
        $advertiser->delete();

        return redirect()->route('web.advertisers.index')->with('deleted', 'Advertiser deleted successfully!');
    }
}
