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

    public static function translation(): array
    {
        return [
             'Alcohol' => 'Alcohol',
             'Crustaceos' => 'Crustaceos',
             'Lacteos' => 'Lacteos',
             'Huevos' => 'Huevos',
             'Pescado' => 'Pescado',
             'Gluten' => 'Gluten',
             'KetoAmigable' => 'Keto Amigable',
             'AptoParaRiñones' => 'Apto Para Riñones',
             'Kosher' => 'Kosher',
            //  'BajoEnPotasio' => 'Bajo en Potasio',
            //  'BajoEnAzucar' => 'Bajo en Azucar',
             'Lupino' => 'Lupino',
             'Mediterraneo' => 'Mediterraneo',
             'Molusco' => 'Molusco',
             'Mostaza' => 'Mostaza',
             'Aceite' => 'Aceite',
             'DietaPaleo' => 'Dieta Paleo',
             'Mani' => 'Mani',
             'Pescetariano' => 'Pescatariano',
             'Cerdo' => 'Cerdo',
             'CarneRoja' => 'Carne Roja',
             'Sesamo' => 'Sesamo',
             'Marisco' => 'Marisco',
             'Soya' => 'Soya',
             'AzucarConsciente' => 'Azucar Consciente',
             'FrutosSecos' => 'Frutos Secos',
             'Vegano' => 'Vegano',
             'Vegetariano' => 'Vegetariano',
             'Trigo' => 'Trigo',
        ];
    }
}
