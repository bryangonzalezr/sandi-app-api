<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\HybridRelations;
use MongoDB\Laravel\Eloquent\Model as MongoModel;

class Menu extends MongoModel
{
    use HasFactory, HybridRelations;

    protected $connection = 'mongodb';

    protected $collection = 'menus';

    protected $fillable = [
        'name',
        'user_id',
        'sandi_recipe',
        'timespan',
        'type',
        'total_calories',
        'menus',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shoppingList()
    {
        return $this->hasOne(ShoppingList::class);
    }
}
