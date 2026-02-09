<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
  protected $fillable = ['user_id', 'amount', 'received_amount', 'payment_method', 'address', 'status'];

  protected $appends = ['created_at_formatted'];

  public function getCreatedAtFormattedAttribute()
  {
    return Carbon::parse($this->created_at)->format('d.m.y');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
