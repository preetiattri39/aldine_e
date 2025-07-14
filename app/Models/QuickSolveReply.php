<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickSolveReply extends Model
{

    protected $fillable = [
        'question_id',
        'user_id',
        'reply',
    ];

    public function question()
    {
        return $this->belongsTo(QuickSolveQuestion::class, 'question_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->hasMany(QuickSolveReplyReaction::class, 'reply_id');
    }

    public function likes()
    {
        return $this->reactions()->where('reaction_type', 'like');
    }

    public function dislikes()
    {
        return $this->reactions()->where('reaction_type', 'dislike');
    }
}
