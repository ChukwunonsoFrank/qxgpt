<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bonus extends Model
{
    protected $fillable = ['user_id', 'amount', 'type'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
