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
        'density',
        'fat_percentage',
        'z_muscular',
        'muscular_mass',
        'muscular_percentage',
        'pmb',
        'amb',
        'agb',
    ];
}
