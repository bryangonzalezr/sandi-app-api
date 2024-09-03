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
        'total',
        'patient_id',
    ];

    public function setTotalAttribute()
    {
        $this->attributes['total'] = $this->cereales + $this->verduras_gral + $this->verduras_libre_cons
                                    + $this->frutas + $this->carnes_ag + $this->carnes_bg + $this->legumbres +
                                    $this->lacteos_ag + $this->lacteos_bg + $this->lacteos_mg + $this->aceites_grasas +
                                    $this->alim_ricos_lipidos + $this->azucares;
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
