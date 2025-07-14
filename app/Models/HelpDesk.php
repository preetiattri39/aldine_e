<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HelpDesk extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'ticket_id',
        'user_id',
        'title',
        'description',
        // 'priority',
        'status',
        'type',
        'type'
    ];

    public function response(): HasMany
    {
        return $this->HasMany(QueryResponse::class,'help_id','id');
    }
  
    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            $user_type_id = 2;
            
            $latestSurvey = HelpDesk::orderBy('id', 'desc')->first();
    
            if ($latestSurvey) {
                $latestId = intval(substr($latestSurvey->ticket_id, -5));
                $newId = $latestId + 1;
                $model->ticket_id = $user_type_id . '00' . date('y') . str_pad($newId, 5, '0', STR_PAD_LEFT);
            } else {
                $model->ticket_id = $user_type_id . '00' . date('y') . '00001'; 
            }
        });
    }

}
