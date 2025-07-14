<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CreateAdminLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    function login(CreateAdminLoginRequest $request)
    {
        $data = $request->validated();

        if(!isset($data['remember']))
        {
            $data['remember'] = 0;
        }

        $credentials = [
            'email'    => $data['email'],
            'password' => $data['password'],
        ];

        if (Auth::attempt($credentials,$data['remember'])) {
            return redirect()->route('view.admin.dashboard')->with('success', 'Login successful!');
        }
        
        session()->flash('error','Invalid Credentials');
        return redirect()->back()->withInput();
        
    }
}
