<?php

namespace App\Models;

use App\Enums\Period;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuscriptionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'period',
    ];

    protected function casts()
    {
        return [
            'period' => Period::class,
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'suscriptions', 'suscription_type_id', 'user_id');
    }
}
