<?php

// Spot Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Spot extends Model
{

    protected $fillable = ['ad_id', 'day_of_week', 'time_of_day', 'status'];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}

