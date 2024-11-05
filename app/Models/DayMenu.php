<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\HybridRelations;
use MongoDB\Laravel\Eloquent\Model as MongoModel;

class DayMenu extends MongoModel
{
    use HasFactory, HybridRelations;

    protected $connection = 'mongodb';

    protected $collection = 'day_menus';

    protected $fillable = [
        'name',
        'user_id',
        'sandi_recipe',
        'type',
        'recipes',
        'total_calories',
    ];

    public function getDaymenu($recipe, $total_calories)
    {
        $day_menu = [
            "recipes" => $recipe,
            "total_calories" => $total_calories,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shoppingList()
    {
        return $this->hasOne(ShoppingList::class);
    }
}
