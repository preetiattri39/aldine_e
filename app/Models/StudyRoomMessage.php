<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyRoomMessage extends Model
{
    protected $fillable = [
        'study_room_id',
        'user_id',
        'message',
    ];

}
