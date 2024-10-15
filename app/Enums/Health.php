<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum Health: string
{
    use EnumToArray;

    case LibreEnAlcohol = 'alcohol-free';
    case LibreEnCrustaceos = 'crustacean-free';
    case LibreEnLacteos = 'dairy-free';
    case LibreEnHuevos = 'egg-free';
    case LibreEnPescado = 'fish-free';
    case LibreEnGluten = 'gluten-free';
    case KetoAmigable = 'keto-friendly';
    case AptoParaRiñones = 'kidney-friendly';
    case Kosher = 'kosher';
    case BajoEnPotasio = 'low-potassium';
    case BajoEnAzucar = 'low-sugar';
    case LibreEnLupino = 'lupine-free';
    case Mediterraneo = 'mediterranean';
    case LibreEnMolusco = 'mollusk-free';
    case LibreEnMostaza = 'mustard-free';
    case SinAceiteAñadido = 'no-oil-added';
    case DietaPaleo = 'paleo';
    case LibreEnMani = 'peanut-free';
    case Pescetariano = 'pescatarian';
    case LibreEnCerdo = 'pork-free';
    case LibreEnCarneRoja = 'red-meat-free';
    case LibreEnSesamo = 'sesame-free';
    case LibreEnMarisco = 'shellfish-free';
    case LibreEnSoya = 'soy-free';
    case AzucarConsciente = 'sugar-conscious';
    case LibreEnFrutosSecos = 'tree-nut-free';
    case Vegano = 'vegan';
    case Vegetariano = 'vegetarian';
    case LibreEnTrigo = 'wheat-free';

    public static function translation(): array
    {
        return [
             'LibreEnAlcohol' => 'Alcohol',
             'LibreEnCrustaceos' => 'Crustaceos',
             'LibreEnLacteos' => 'Lacteos',
             'LibreEnHuevos' => 'Huevos',
             'LibreEnPescado' => 'Pescado',
             'LibreEnGluten' => 'Gluten',
             'KetoAmigable' => 'Keto Amigable',
             'AptoParaRiñones' => 'Apto Para Riñones',
             'Kosher' => 'Kosher',
             'BajoEnPotasio' => 'Bajo en Potasio',
             'BajoEnAzucar' => 'Bajo en Azucar',
             'LibreEnLupino' => 'Lupino',
             'Mediterraneo' => 'Mediterraneo',
             'LibreEnMolusco' => 'Molusco',
             'LibreEnMostaza' => 'Mostaza',
             'SinAceiteAñadido' => 'Aceite',
             'DietaPaleo' => 'Dieta Paleo',
             'LibreEnMani' => 'Mani',
             'Pescetariano' => 'Pescatariano',
             'LibreEnCerdo' => 'Cerdo',
             'LibreEnCarneRoja' => 'Carne Roja',
             'LibreEnSesamo' => 'Sesamo',
             'LibreEnMarisco' => 'Marisco',
             'LibreEnSoya' => 'Soya',
             'AzucarConsciente' => 'Azucar Consciente',
             'LibreEnFrutosSecos' => 'Frutos Secos',
             'Vegano' => 'Vegano',
             'Vegetariano' => 'Vegetariano',
             'LibreEnTrigo' => 'Trigo',
        ];

    }
}
