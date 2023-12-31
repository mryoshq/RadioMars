<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Ad;
use App\Models\Payment;




class Advertiser extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'firm',
        'user_id', 
    ];
 
    public static function getDomainEnumValues()
    {
        return ['Céramique', 'Maroquinerie', 'Tapisserie', 'Bijouterie', 'Boiserie', 'Métallurgie', 'Textile', 'Vannerie', 'Broderie', 'Poterie'];

    }
    
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
