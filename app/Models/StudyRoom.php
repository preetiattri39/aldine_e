<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyRoom extends Model
{
    protected $fillable = [
    	'creator_id',
        //'user_id',
        'name',
        'code',
        'description',
        'type',
        //'is_public',
    ];
    
    public function members(){
        return $this->hasMany(StudyRoomMember::class, 'room_id');
    }
    
    public function requests()
    {
        return $this->hasMany(StudyRoomRequest::class, 'room_id');
    }
}
