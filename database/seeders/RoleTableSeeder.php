<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(
            ["name"=> config('constants.ROLES.ADMIN')], 
            ["name"=> config('constants.ROLES.ADMIN')]
        );
        Role::updateOrCreate(
            ["name"=> config('constants.ROLES.USER')], 
            ["name"=> config('constants.ROLES.USER')]
        );
    }
}
