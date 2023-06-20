<?php

// RoleController
namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('web.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('web.roles.create'); 
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);
    
        $role = new Role();
        $role->name = $validatedData['name'];
        $role->permissions = json_encode([$validatedData['permissions']]);
        $role->save();
    
        return redirect()->route('web.roles.index')->with('success', 'Role created successfully!');
    }
    

    public function show(Role $role)
    {
        return view('web.roles.show', compact('role'));
    }

        public function edit(Role $role)
    {
        return view('web.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);

        $role->update($validated);

        return redirect()->route('web.roles.index', $role)->with('success', 'Role updated successfully');
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('web.roles.index')->with('deleted', 'Role deleted successfully!');
    }
}
