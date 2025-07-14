<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
        
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $adminUser = User::firstOrCreate(
            [
                'email' => 'admin@yopmail.com', 
            ],
            [
                'name' => 'Admin User', 
                'password' => Hash::make('password'), 
            ]
        );

        $adminUser->assignRole($role);
    }
}
