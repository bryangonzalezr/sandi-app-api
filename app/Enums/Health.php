<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum Health: string
{
    use EnumToArray;

    case Alcohol = 'alcohol-free';
    case Crustaceos = 'crustacean-free';
    case Lacteos = 'dairy-free';
    case Huevos = 'egg-free';
    case Pescado = 'fish-free';
    case Gluten = 'gluten-free';
    case KetoAmigable = 'keto-friendly';
    case AptoParaRiñones = 'kidney-friendly';
    case Kosher = 'kosher';
    // case BajoEnPotasio = 'low-potassium';
    // case BajoEnAzucar = 'low-sugar';
    case Lupino = 'lupine-free';
    case Mediterraneo = 'mediterranean';
    case Molusco = 'mollusk-free';
    case Mostaza = 'mustard-free';
    case Aceite = 'no-oil-added';
    case DietaPaleo = 'paleo';
    case Mani = 'peanut-free';
    case Pescetariano = 'pescatarian';
    case Cerdo = 'pork-free';
    case CarneRoja = 'red-meat-free';
    case Sesamo = 'sesame-free';
    case Marisco = 'shellfish-free';
    case Soya = 'soy-free';
    case AzucarConsciente = 'sugar-conscious';
    case FrutosSecos = 'tree-nut-free';
    case Vegano = 'vegan';
    case Vegetariano = 'vegetarian';
    case Trigo = 'wheat-free';

    public function translation(): array
    {
        return [
             'Alcohol' => ' Libre de Alcohol',
             'Crustaceos' => 'Libre de Crustaceos',
             'Lacteos' => 'Libre de Lacteos',
             'Lactosa' => 'Libre de Lactosa',
             'Pescado' => 'Libre de Pescado',
             'Gluten' => 'Libre de Gluten',
             'KetoAmigable' => 'Keto Amigable',
             'AptoParaRiñones' => 'Apto Para Riñones',
             'Kosher' => 'Kosher',
            //  'BajoEnPotasio' => 'Bajo en Potasio',
            //  'BajoEnAzucar' => 'Bajo en Azucar',
             'Lupino' => 'Libre de Lupino',
             'Mediterraneo' => 'Mediterraneo',
             'Molusco' => 'Libre de Molusco',
             'Mostaza' => 'Libre de Mostaza',
             'Aceite' => 'Sin Aceite',
             'DietaPaleo' => 'Dieta Paleo',
             'Mani' => 'Libre de Mani',
             'Pescetariano' => 'Pescatariano',
             'Cerdo' => 'Libre de Cerdo',
             'CarneRoja' => 'Libre de Carne Roja',
             'Sesamo' => 'Libre de Sesamo',
             'Marisco' => 'Libre de Marisco',
             'Soya' => 'Libre de Soya',
             'AzucarConsciente' => 'Azucar Consciente',
             'FrutosSecos' => 'Sin Frutos Secos',
             'Vegano' => 'Vegano',
             'Vegetariano' => 'Vegetariano',
             'Trigo' => 'Libre de Trigo',
        ];
    }
}
