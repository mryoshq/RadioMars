<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  \Illuminate\Support\Facades\Auth  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) // Check if user is logged in
            return response()->json(['message' => 'Please log in first'], 401);
        
        $user = Auth::user(); 

        // Check if user role is in the allowed roles
        if (in_array($user->role->name, $roles))
            return $next($request);

        return response()->json(['message' => 'You do not have permission to access this resource'], 403);
    }
}
 