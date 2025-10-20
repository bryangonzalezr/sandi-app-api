<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ordinal'
    ];

    protected $timestamp = false;

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }
}
