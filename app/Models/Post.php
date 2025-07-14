<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['user_id', 'title', 'content', 'type'];

    protected $casts = [
    'images' => 'array',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)->whereNull('parent_id');
    }

    public function postType()
    {
        return $this->belongsTo(PostType::class, 'type', 'slug');
    }

    public function pinnedByUsers(){
        return $this->belongsToMany(User::class, 'pinned_posts')->withTimestamps();
    }

    public function likedByUsers(){
        return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
    }

    public function allComments()
    {
        return $this->hasMany(Reply::class);
    }

}  
