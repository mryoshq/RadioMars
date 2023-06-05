<?php

// Role Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'permissions'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
