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
        $allPermissions = ['manage_users', 'manage_roles', 'manage_advertisers', 'manage_packs', 'manage_ads', 'manage_payments', 'view_users', 'view_roles', 'view_packs', 'launch_ads']; 

        return view('web.roles.create', compact( 'allPermissions'));

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);
    
        $role = new Role();
        $role->name = $validatedData['name'];
        $role->permissions = $validatedData['permissions'];
        $role->save();
    
        return redirect()->route('web.roles.index')->with('success', 'Role created successfully!');
    }
    
    

    public function show(Role $role)
    { 
        return view('web.roles.show', compact('role'));
    }

      
    public function edit(Role $role)
    {
        $allPermissions = ['manage_users', 'manage_roles', 'manage_advertisers', 'manage_packs', 'manage_ads', 'manage_payments', 'view_users', 'view_roles', 'view_packs', 'launch_ads']; 
        return view('web.roles.edit', compact('role', 'allPermissions'));
    }


    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required',
            'permissions' => 'required|array',
        ]);
    
        $role->name = $validated['name'];
        $role->permissions = $validated['permissions'];
        $role->save();
    
        return redirect()->route('web.roles.index')->with('success', 'Role updated successfully');
    }
    


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('web.roles.index')->with('deleted', 'Role deleted successfully!');
    }
}
