<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portion extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $fillable = [
        'cereales',
        'verduras_gral',
        'verduras_libre_cons',
        'frutas',
        'carnes_ag',
        'carnes_bg',
        'legumbres',
        'lacteos_ag',
        'lacteos_bg',
        'lacteos_mg',
        'aceites_grasas',
        'alim_ricos_lipidos',
        'azucares',
        'patient_id',
    ];
}
