<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'food',
        'calorias',
        'cho',
        'lipidos',
        'proteinas',
    ];

}
