<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'shopping_lists';

    protected $fillable = [
        'menu_id',
        'list',
        'amounts',
        'menu_type'
    ];

    public function dayMenu()
    {
        return $this->belongsTo(DayMenu::class, 'menu_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
