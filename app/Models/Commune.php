<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $fillable = [
        'province_id',
        'name',
    ];

    public $timestamps = false;

    public function provinces()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function contactCards()
    {
        return $this->hasMany(ContactCard::class);
    }
}
