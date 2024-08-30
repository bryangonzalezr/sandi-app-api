<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model as MongoModel;

class NutritionalProfile extends MongoModel
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $fillable  = [
        'patient_id',
        'description',
        'height',
        'weight',
        'phisical_activity',
        'habits',
        'allergies',
        'intolerances',
        'morbid_antecedents',
        'family_antecedents',
        'digestion',
        'subjective_assessment',
        'nutritional_anamnesis',

    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
