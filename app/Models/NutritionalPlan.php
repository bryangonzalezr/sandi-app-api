<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NutritionalPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mongodb';

    protected $fillable = [
        'patient_id',
        'desayuno',
        'colacion',
        'almuerzo',
        'once',
        'cena',
        'general_recommendations',
        'forbidden_foods',
        'free_foods',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
