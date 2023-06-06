<?php

// Pack Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pack extends Model
{

    use HasFactory;
    protected $fillable = ['name', 'price', 'spots_number', 'days_of_week', 'times_of_day', 'availability'];

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }
} 
