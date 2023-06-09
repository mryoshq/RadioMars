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

    protected $fillable = ['user_id','reservation_id', 'amount','payment_method', 'status',];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
