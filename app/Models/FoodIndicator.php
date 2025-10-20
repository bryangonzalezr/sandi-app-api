<?php

namespace App\Models;

use App\Enums\Food;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodIndicator extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $fillable = [
        'food',
        'calorias',
        'cho',
        'lipidos',
        'proteinas',
    ];

    protected $casts = [
        'food' => Food::class,
    ];

}
