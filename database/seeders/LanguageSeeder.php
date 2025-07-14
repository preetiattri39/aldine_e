<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        Language::insert([
            ['code' => 'en', 'is_default' => 1, 'name' => 'English'],
            ['code' => 'es', 'is_default' => 0, 'name' => 'Español'],
            ['code' => 'fr', 'is_default' => 0, 'name' => 'Français'],
        ]);
    }
}
