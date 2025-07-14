<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostShare extends Model
{
    protected $fillable = [
        'post_id',
        'sender_id',
        'recipient_id',
        'share_type',
    ];

    // Relationships (optional)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
