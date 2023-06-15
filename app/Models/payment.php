<?php

// Payment Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['payment_method', 'status','advertiser_id','ad_id'];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}
  