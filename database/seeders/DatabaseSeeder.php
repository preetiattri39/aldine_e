<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     
        $this->call([

            RoleTableSeeder::class,
            UsersTableSeeder::class,
            ConfigSettingTableSeeder::class,
            EmailTemplateSeeder::class,
            ContentPageSeeder::class,
            LanguageSeeder::class,
            PostTypesTableSeeder::class,
            ConfigSettingTableSeeder::class,
            MajorSeeder::class,
            ProgramSeeder::class,

         
        ]);
    }
}
