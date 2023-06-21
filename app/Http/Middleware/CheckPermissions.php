<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermissions
{ 
    public function handle($request, Closure $next, ...$permissions)
    {
        $user = Auth::user();
        $rolePermissions = $user->role->permissions;

        foreach ($permissions as $permission) {
            if (!in_array($permission, $rolePermissions)) {
                return redirect()->route('access-denied');
            }
        }

        return $next($request);
    }
}
