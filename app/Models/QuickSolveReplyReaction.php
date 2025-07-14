<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickSolveReplyReaction extends Model
{
    protected $fillable = [
        'reply_id',
        'user_id',
        'reaction_type',
    ];

    public function reply()
    {
        return $this->belongsTo(QuickSolveReply::class, 'reply_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
