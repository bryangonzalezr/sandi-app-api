<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as MongoModel;
use MongoDB\Laravel\Relations\BelongsToMany;

class DayMenu extends MongoModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'recipes',
        'total_calories',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
