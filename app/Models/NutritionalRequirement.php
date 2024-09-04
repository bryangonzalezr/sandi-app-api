<?php

namespace App\Models;

use App\Enums\GetMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionalRequirement extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $casts = [
        'method' => GetMethod::class,
    ];

    protected $fillable = [
        'patient_id',
        'method',
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
