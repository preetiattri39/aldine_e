<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavoriteSubject extends Model
{
   
    protected $table = 'user_favorite_subjects';

    protected $fillable = [
        'user_id',
        'category_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category() // This is your subject
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
