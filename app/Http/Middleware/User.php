<?php

namespace App\Http\Middleware;

use App\Traits\SendResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    use SendResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((getRoleNameById(authId()) != config('constants.ROLES.USER')) ) {
            $user =  Auth::user();
            $user->currentAccessToken()->delete();
            return $this->apiResponse('error',403,config('constants.ERROR.AUTHORIZATION'));
        }

        if(Auth::user()->status == 0){
            $user =  Auth::user();
            $user->currentAccessToken()->delete();
            return $this->apiResponse('error',401,config('constants.ERROR.AUTHORIZATION'));
        }
        
        return $next($request);
    }
}
