<?php

namespace App\Models;

use App\Enums\NutritionalState;
use App\Enums\PatientType;
use App\Enums\PhysicalActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model as MongoModel;

class NutritionalProfile extends MongoModel
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $casts = [
        /* 'patient_type' => PatientType::class,
        'physical_status' => PhysicalActivity::class,
        'nutritional_state' => NutritionalState::class, */
    ];

    protected $fillable  = [
        'patient_id',
        'nutritional_state',
        'description',
        'height',
        'weight',
        'physical_comentario',
        'physical_status',
        'habits',
        'allergies',
        'morbid_antecedents',
        'patient_type',
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
