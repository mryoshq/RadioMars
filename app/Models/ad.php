<?php

// Ad Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use HasFactory, SoftDeletes;  

    protected $fillable = [ 'text_content', 'audio_content','status', 'advertiser_id', 'pack_id'];

    public function advertiser(): BelongsTo
    {
        return $this->belongsTo(Advertiser::class);
    }
    public function pack(): BelongsTo
    {
        return $this->belongsTo(Pack::class);
    }
 
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    
}