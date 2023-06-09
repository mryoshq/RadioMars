<?php

// Reservation Model 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['ad_id', 'status'];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class); 
    }

    public function spots(): HasMany
    {
        return $this->hasMany(Spot::class);
    }
}
