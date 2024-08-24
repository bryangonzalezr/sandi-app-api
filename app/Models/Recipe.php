<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as MongoModel;

class Recipe extends MongoModel
{
    use HasFactory;

    protected $fillable = [
        'label',
        'diet_labels',
        'health_labels',
        'cautions',
        'ingredient_lines',
        'calories',
        'glycemic_index',
        'inflammatory_index',
        'meal_type',
        'dish_type',
        'instructions',
        'user_id',
    ];
}
