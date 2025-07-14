<?php

namespace Database\Seeders;

use App\Models\ConfigSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ConfigSetting::updateOrCreate([
            'type' => 'smtp',
            'key' => 'from_email'],
            ['value' => 'developer@esferasoft.com'
        ]);
        ConfigSetting::updateOrCreate([
            'type' => 'smtp',
            'key' => 'host'],
            ['value' => 'smtp.gmail.com'
        ]);
        ConfigSetting::updateOrCreate([
            'type' => 'smtp',
            'key' => 'port'],
            ['value' => '587'
        ]);
        ConfigSetting::updateOrCreate([
            'type' => 'smtp',
            'key' => 'username'],
            ['value' => 'developer@esferasoft.com'
        ]);
        ConfigSetting::updateOrCreate([
            'type' => 'smtp',
            'key' => 'from_name'],
            ['value' => 'Aldine E'
        ]);
        ConfigSetting::updateOrCreate([
            'type' => 'smtp',
            'key' => 'password'],
            ['value' => 'cffohbxqithkysai'
        ]);
        ConfigSetting::updateOrCreate([
            'type' => 'smtp',
            'key' => 'encryption'],
            ['value' => 'tls'
        ]);
			
	


        // Config Setting
        ConfigSetting::updateOrCreate(['type' => 'config','key' => 'instagram'],['value' => 'https://www.instagram.com/edupalz/?utm_source=ig_web_button_share_sheet']);
        ConfigSetting::updateOrCreate(['type' => 'config','key' => 'tiktok'],['value' => 'https://www.tiktok.com/@edupalz']);
        ConfigSetting::updateOrCreate(['type' => 'config','key' => 'reddit'],['value' => 'https://www.reddit.com/user/Edupalz/']);
  

    }
}
