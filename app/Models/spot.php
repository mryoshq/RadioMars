<?php

// Spot Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spot extends Model
{
    use HasFactory;
    protected $fillable = ['ad_id', 'day_of_week', 'time_of_day', 'status'];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}

