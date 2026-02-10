<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DepositIntent extends Model
{
  protected $fillable = ['user_id', 'name', 'amount', 'payment_method', 'allow_referral', 'status'];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
