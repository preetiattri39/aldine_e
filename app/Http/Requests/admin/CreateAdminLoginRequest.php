<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminLoginRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'email'    => 'required|email|exists:users,email|max:50',
            'password' => 'required|max:50',
            'remember' => 'boolean',
        ];
    }
}
