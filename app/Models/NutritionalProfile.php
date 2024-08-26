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
        'height',
        'weight',
        'phisical_activity',
        'habits',
        'allergies',
        'intolerances',
        'morbid_antecedents',
        'family_antecedents',
        'subjective_assessment',
        'bicipital_skinfold',
        'tricipital_skinfold',
        'subescapular_skinfold',
        'supraspinal_skinfold',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class);
    }
}
