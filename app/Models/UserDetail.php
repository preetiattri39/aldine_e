<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'language',
        'school_name',
        'education_level',
        'academic_year',
        'graduating_year',
        'program',
        'major',
        'minor'
    ];

}
