<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as MongoModel;
use MongoDB\Laravel\Relations\BelongsToMany;

class Menu extends MongoModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'timespan',
        'total_calories',
        'menus',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
