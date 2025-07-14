<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes,Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = ['full_name'];
    protected $fillable = [
       'role_id',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'is_email_verified',
        'password',
        'birthday',
        'gender',
        'address',
        'country_code',
        'country_short_code',
        'phone_number',
        'profile_pic',
        'zip_code',
        'country',
        'bio',
        'status',
        'is_profile_updated'
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getFullNameAttribute()
    {
        return ucwords("{$this->first_name} {$this->last_name}");
    }
    public function role(): BelongsTo
    {
        return $this->BelongsTo(Role::class);
    }

    public function userDetail(): HasOne
    {
        return $this->HasOne(UserDetail::class);
    }

public function favoriteSubjects()
{
    return $this->belongsToMany(Category::class, 'user_favorite_subjects', 'user_id', 'category_id');
}

public function connections() {
    return $this->hasMany(Connection::class, 'user_id');
}

public function connectedUsers() {
    return $this->hasMany(Connection::class, 'connection_id');
}

public function pinnedPosts()
{
    return $this->belongsToMany(Post::class, 'pinned_posts')->withTimestamps();
}



public function likedPosts()
{
    return $this->belongsToMany(Post::class, 'post_likes')->withTimestamps();
}


 
}
