<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = [
        'name', // Add more if you have other columns like 'created_by'
    ];

    // Relationships
    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }


    public function members()
{
    return $this->belongsToMany(User::class, 'chat_room_users', 'chat_room_id', 'user_id');
}

public function latestMessage()
{
    return $this->hasOne(ChatMessage::class)->latestOfMany();
}
}
