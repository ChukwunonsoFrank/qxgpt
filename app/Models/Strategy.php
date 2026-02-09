<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategy extends Model
{
    protected $fillable = ['name', 'min_amount', 'max_amount', 'min_roi', 'max_roi', 'image_url', 'status', 'duration'];
}
