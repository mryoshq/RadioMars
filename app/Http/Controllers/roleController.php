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
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create'); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);
    
        $role = Role::create($validated);
    
        return redirect()->route('roles.show', $role)->with('success', 'Role created successfully');
    }

    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);

        $role->update($validated);

        return redirect()->route('roles.show', $role);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index');
    }
}
