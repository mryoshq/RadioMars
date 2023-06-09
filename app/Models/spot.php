<?php

// Spot Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spot extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['pack_id','reservation_id', 'day_of_week', 'time_of_day', 'status'];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
      
    public function pack(): BelongsTo
    {
        return $this->belongsTo(Pack::class);
    }
}

