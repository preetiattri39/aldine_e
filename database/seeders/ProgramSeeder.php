<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        $programs = [
            'Bachelor of Architecture (BArch)',
            'Bachelor of Biotechnology',
            'Bachelor of Business Administration (BBA)',
            'Bachelor of Civil Engineering (BCE)',
            'Bachelor of Computer Science',
            'Bachelor of Cybersecurity',
            'Bachelor of Data Science & AI',
            'Bachelor of Economics (BEc)',
            'Bachelor of Electrical and Electronics Engineering (BEEE)',
            'Bachelor of Environmental Science',
            'Bachelor of Finance & Accounting',
            'Bachelor of Information Technology (BIT)',
            'Bachelor of International Relations',
            'Bachelor of Journalism & Media Studies',
            'Bachelor of Law (LLB)',
            'Bachelor of Marketing & Digital Media',
            'Bachelor of Mechanical Engineering (BEng/BSME)',
            'Bachelor of Medicine & Surgery (MBBS)',
            'Bachelor of Nursing (BN)',
            'Bachelor of Psychology',
            'Bachelor of Science',
            'Master of Architecture (MArch)',
            'Master of Artificial Intelligence & Machine Learning',
            'Master of Business Administration (MBA)',
            'Master of Computer Science (MCS)',
            'Master of Cybersecurity',
            'Master of Data Science (MDS)',
            'Master of Digital Marketing',
            'Master of Economics (MEc)',
            'Master of Engineering (MEng - Various Specializations)',
            'Master of Environmental Management',
            'Master of Finance (MFin)',
            'Master of Human Resource Management (MHRM)',
            'Master of International Business (MIB)',
            'Master of Laws (LLM)',
            'Master of Psychology (Clinical, Counseling, etc.)',
            'Master of Public Health (MPH)',
            'Master of Social Work (MSW)',
        ];

        foreach ($programs as $program) {
            Program::create([
                'name' => $program,
                'status' => 1 
            ]);
        }
    }
}

