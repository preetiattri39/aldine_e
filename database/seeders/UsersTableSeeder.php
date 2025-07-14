<?php

namespace Database\Seeders;

use App\Models\{Role, User,UserDetail};
use App\Notifications\UserNotification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create admin detaiils
        $role = Role::where('name' , config('constants.ROLES.ADMIN'))->first();
        User::updateOrCreate([
            'email'             => "admin@yopmail.com",
            'role_id'           => $role->id],[
            'first_name'        =>  'super',
            'last_name'         =>  'admin',
            'password'          =>   Hash::make('Admin@123'),
            'is_email_verified' =>  1
        ]);
        $admin = User::where('email' , "admin@yopmail.com")->first();
       

        //create users
        $role = Role::where('name' , config('constants.ROLES.USER'))->first();
        User::updateOrCreate([
            'email'             => "john@yopmail.com",
            'role_id'           => $role->id],[
            'first_name'        =>  'john',
            'last_name'         =>  'smith',
            'password'          =>   Hash::make('Pass@123'),
        ]);
        $user = User::where('email' , "john@yopmail.com")->first();
        
        User::find($user->id)->notify(new UserNotification($user->full_name));

        User::updateOrCreate([
            'email'             => "Amy@yopmail.com",
            'role_id'           => $role->id],[
            'first_name'        =>  'Alison',
            'last_name'         =>  'Amy',
            'password'          =>   Hash::make('Pass@123'),
        ]);
        $user = User::where('email' , "Amy@yopmail.com")->first();
       
        User::find($user->id)->notify(new UserNotification($user->full_name));

        User::updateOrCreate([
            'email'             => "Jake@yopmail.com",
            'role_id'           => $role->id],[
            'first_name'        =>  'Jake',
            'last_name'         =>  'Sharma',
            'password'          =>   Hash::make('Pass@123'),
        ]);
        $user = User::where('email' , "Jake@yopmail.com")->first();
        
        User::find($user->id)->notify(new UserNotification($user->full_name));


    
    }
}
