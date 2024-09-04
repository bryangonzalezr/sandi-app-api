<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionalRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'get',
        'proteina',
        'lipidos',
        'carbohidratos',
        'agua',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
