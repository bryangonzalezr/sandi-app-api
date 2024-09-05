<?php

namespace App\Models;

use App\Enums\GetMethod;
use App\Enums\RestFactor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionalRequirement extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $casts = [
        'method' => GetMethod::class,
        'rest_type' => RestFactor::class,
    ];

    protected $fillable = [
        'patient_id',
        'method',
        'rest_type',
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
