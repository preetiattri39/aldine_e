<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyRoomMember extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'status', 
    ];


    public function members(){
        return $this->hasMany(StudyRoomMember::class, 'study_room_id');
    }

    public function requests()
    {
        return $this->hasMany(StudyRoomRequest::class, 'study_room_id');
    }

}
