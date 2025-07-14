<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickSolveQuestionReaction extends Model
{
    protected $fillable = ['question_id', 'user_id', 'reaction_type'];

    public function question()
    {
        return $this->belongsTo(QuickSolveQuestion::class);
    }
    
}
