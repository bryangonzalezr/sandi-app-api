<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as MongoModel;
use MongoDB\Laravel\Eloquent\SoftDeletes as MongoSoftDeletes;

class NutritionalPlan extends MongoModel
{
    use HasFactory, MongoSoftDeletes;

    protected $connection = 'mongodb';

    protected $collection = 'nutritional_plans';

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
