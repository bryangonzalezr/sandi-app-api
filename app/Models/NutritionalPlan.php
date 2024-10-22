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
        'nutritional_requirement_id',
        'portion_id',
        'service_portion_id',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function nutritionalRequirement()
    {
        return $this->hasOne(NutritionalRequirement::class, 'nutritional_requirement_id');
    }

    public function portion()
    {
        return $this->hasOne(Portion::class, 'portion_id');
    }

    public function servicePortions()
    {
        return $this->hasMany(ServicePortion::class, 'service_portion_id');
    }
}
