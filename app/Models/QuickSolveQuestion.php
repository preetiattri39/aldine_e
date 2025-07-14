<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class QuickSolveQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'user_id',
        'question',
        'hours_earned',
        'coins',
        'points',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function replies()
    {
        return $this->hasMany(QuickSolveReply::class, 'question_id');
    }
    public function reactions(){
        return $this->hasMany(QuickSolveQuestionReaction::class, 'question_id');
    }
    public function subcategory()
{
    return $this->belongsTo(SubCategory::class);
}
}
