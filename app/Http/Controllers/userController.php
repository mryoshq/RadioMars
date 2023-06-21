<?php

// UserController
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::whereIn('role_id', [1, 2, 3])->latest()->get();
        return view('web.users.index', compact('users'));
    }
    

    public function create()
    {
        $user = new User();
        $roles = Role::all();
        return view('web.users.create', compact('user', 'roles'));
    }
    
    
    

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone_number' => ['required', 'regex:/^0[67][0-9]{8}$/', 'unique:users'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ]);
    
        // Create a new user
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone_number' => $validatedData['phone_number'],
            'role_id' => $validatedData['role_id'], 
        ]);
    
        // Redirect the user back with a success message
        return redirect()->route('web.users.index')->with('success', 'User created successfully');
    }
    

    public function show(User $user)
    {
        return view('web.users.show', compact('user'));
    }
 
    public function edit(User $user)
{
    $roles = Role::all();  // Assuming you have a Role model to fetch all roles.
    return view('web.users.edit', compact('user', 'roles'));
}

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        'password' => ['nullable', 'string', 'min:8'],
        'phone_number' => ['required', 'regex:/^0[67][0-9]{8}$/', 'unique:users,phone_number,'.$user->id],
        'role_id' => ['required', 'integer', 'exists:roles,id'],
    ]);

    if($request->filled('password')) {
        $validated['password'] = Hash::make($request->password);
    } else {
        // if password input is not filled, exclude it from the update data
        unset($validated['password']);
    }

    $user->update($validated);

    return redirect()->route('web.users.index')->with('success', 'User updated successfully.');
}




    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('web.users.index')->with('deleted', 'User deleted successfully!');
    }
}
