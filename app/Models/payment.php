<?php

// Payment Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['reservation_id', 'amount', 'payment_date', 'status', 'payment_method'];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
