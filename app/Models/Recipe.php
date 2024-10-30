<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as MongoModel;

class Recipe extends MongoModel
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'recipes';

    protected $fillable = [
        'label',
        'dietLabels',
        'healthLabels',
        'ingredientLines',
        'ingredients',
        'calories',
        'mealType',
        'dishType',
        'instructions',
        'user_id',
        'sandi_recipe'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
