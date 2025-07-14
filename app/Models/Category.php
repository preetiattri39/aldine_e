<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'status',
    ];
    public function usersWhoFavorited()
    {
        return $this->belongsToMany(User::class, 'user_favorite_subjects', 'category_id', 'user_id');
    }
    
  
    public function subcategories()
    {
	return $this->hasMany(SubCategory::class);
    }
}
