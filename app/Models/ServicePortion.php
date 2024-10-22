<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model as MongoModel;

class ServicePortion extends MongoModel
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'service_portions';

    protected $fillable = [
        'desayuno',
        'colacion',
        'almuerzo',
        'once',
        'cena',
        'total_calorias',
        'patient_id'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function nutritionalPlan()
    {
        return $this->belongsTo(NutritionalPlan::class);
    }

    // Define un mutador para calcular y establecer total_calorias
   /*  public function setTotalCaloriasAttribute()
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
    } */

}
