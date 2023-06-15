<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advertiser extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'firm',
        'user_id', 
    ];
     
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }
 
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
    

    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(Payment::class, Ad::class);
    }
}
