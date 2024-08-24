<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'imc',
        'dencity',
        'siri_fat_percentage',
        'slaughter_fat_percentage',
        'muscle_mass',
        'brachial_fat_area',
        'arm_muscle_area',
    ];
}
