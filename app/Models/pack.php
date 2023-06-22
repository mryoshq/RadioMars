<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Ad;

class Pack extends Model
{

    use HasFactory;
    protected $fillable = ['name', 'description', 'period', 'price', 'spots_number', 'days_of_week', 'times_of_day', 'availability','variations'];

 
    protected $casts = [
        'period' => 'array',
        'price' => 'array',
        'spots_number' => 'array',
     
        'days_of_week' => 'array',
        'times_of_day' => 'array',
        
        'availability' => 'array',
    ];
    
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }
}  
 