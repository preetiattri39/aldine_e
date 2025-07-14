<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyRoomRequest extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'status', 
    ];
}
