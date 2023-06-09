<?php

// Ad Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = ['campaign_id', 'pack_id', 'text_content', 'audio_content','status'];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
 
    public function reservation(): HasOne
    {
        return $this->hasOne(Reservation::class);
    }
    public function spots(): HasManyThrough
    {
        return $this->hasManyThrough(Spot::class, Reservation::class);
    }
    
}