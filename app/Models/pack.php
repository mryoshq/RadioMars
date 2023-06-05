<?php

// Pack Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Pack extends Model
{


    protected $fillable = ['price', 'spots_number', 'availability'];

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }
}
