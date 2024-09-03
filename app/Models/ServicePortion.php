<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePortion extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

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

    // Define un mutador para calcular y establecer total_calorias
    public function setTotalCaloriasAttribute()
    {
        $total = 0;

        // Listar todas las categorías
        $categories = [
            'cereales', 'verduras_gral', 'verduras_libre_cons', 'frutas',
            'carnes_ag', 'carnes_bg', 'legumbres', 'lacteos_ag',
            'lacteos_bg', 'lacteos_mg', 'aceites_grasas', 'alim_ricos_lipidos',
            'azucares'
        ];

        // Sumar todas las calorías de cada categoría para cada momento del día
        foreach ($categories as $category) {
            if (isset($this->attributes[$category])) {
                foreach ($this->attributes[$category] as $time => $value) {
                    if (is_numeric($value)) {
                        $total += $value;
                    }
                }
            }
        }

        $this->attributes['total_calorias'] = $total;
    }

}
