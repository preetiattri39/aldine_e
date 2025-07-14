<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueryResponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'help_id',
        'user_id',
        'type',
        'crypto_subscription_id',
        'response',
    ];

    public function cryptoSubscription(): BelongsTo
    {
        return $this->BelongsTo(CryptoSubscription::class,'crypto_subscription_id');
    }


}
