<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    public function run()
    {
        $majors = [
            'Computer Science',
            'Mechanical Engineering',
            'Electrical Engineering',
            'Civil Engineering',
            'Business Administration',
            'Finance',
            'Accounting',
            'Marketing',
            'Economics',
            'Psychology',
            'Political Science',
            'Biology',
            'Chemistry',
            'Physics',
            'Mathematics',
            'Nursing',
            'Medicine (MBBS/MD)',
            'Pharmacy',
            'Law (LLB/JD)',
            'Architecture',
            'Environmental Science',
            'Data Science',
            'Artificial Intelligence',
            'Cybersecurity',
            'Journalism & Mass Communication',
        ];

        foreach ($majors as $major) {
            Major::create(['name' => $major]);
        }
    }
}
