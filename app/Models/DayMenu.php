<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as MongoModel;
use MongoDB\Laravel\Relations\BelongsTo;

class DayMenu extends MongoModel
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'day_menus';

    protected $fillable = [
        'name',
        'user_id',
        'sandi_recipe',
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
}
