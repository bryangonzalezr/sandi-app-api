<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as MongoModel;
use MongoDB\Laravel\Relations\BelongsTo;

class Menu extends MongoModel
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'menus';

    protected $fillable = [
        'name',
        'user_id',
        'timespan',
        'total_calories',
        'menus',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
