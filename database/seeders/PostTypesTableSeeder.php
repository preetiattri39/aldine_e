<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PostTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
        DB::table('post_types')->insert([
            [
                'slug' => 'tough_days',
                'title' => 'Tough Days',
                'subtitle' => "You're Not Alone, Share Your Struggles",
            ],
            [
                'slug' => 'exam_grind',
                'title' => 'Exam Grind',
                'subtitle' => "Push Through! Share Encouragement for Exam Time!",
            ],
            [
                'slug' => 'study_wins',
                'title' => 'Study Wins',
                'subtitle' => "Celebrate Your Study Success!",
            ],
            [
                'slug' => 'daily_reminders',
                'title' => 'Daily Reminders',
                'subtitle' => "Stay Inspired with Daily Affirmations!",
            ],
        ]);
    }
}
