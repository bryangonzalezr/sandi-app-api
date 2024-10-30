<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'region_id'
    ];

    protected $timestamp = false;

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }

    public function regions()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
