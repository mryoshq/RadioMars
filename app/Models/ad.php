<?php

// Ad Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Advertiser;
use App\Models\Pack;
use App\Models\Payment;


class Ad extends Model
{
    use HasFactory, SoftDeletes;  

    protected $fillable = [ 'text_content', 'audio_content','status', 'advertiser_id', 'pack_id', 'pack_variation'];


    protected static function booted()
    {
        static::creating(function ($ad) {
            $ad->status = 'not_active';
        });
    }
    
    public function advertiser(): BelongsTo
    {
        return $this->belongsTo(Advertiser::class);
    }
    public function pack(): BelongsTo
    {
        return $this->belongsTo(Pack::class);
    }
 
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
    
    
}