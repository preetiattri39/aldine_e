<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (getRoleNameById(authId()) != config('constants.ROLES.ADMIN')) {
            Auth::logout();
            return redirect()->route('login')->with("error",config('constants.ERROR.AUTHORIZATION'));
        }
        
        return $next($request);
    }
}
