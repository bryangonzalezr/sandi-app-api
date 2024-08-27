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
    case BajoEnPotasio = 'low-potassium';
    case BajoEnAzucar = 'low-sugar';
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
             'LibreDeAlcohol' => ' Libre de Alcohol',
             'LibreDeCrustaceos' => 'Libre de Crustaceos',
             'LibreDeLacteos' => 'Libre de Lacteos',
             'LibreDeLactosa' => 'Libre de Lactosa',
             'LibreDePescado' => 'Libre de Pescado',
             'LibreDeGluten' => 'Libre de Gluten',
             'KetoAmigable' => 'Keto Amigable',
             'AptoParaRiñones' => 'Apto Para Riñones',
             'Kosher' => 'kosher',
             'BajoEnPotasio' => 'low-potassium',
             'BajoEnAzucar' => 'low-sugar',
             'LibreDeLupino' => 'lupine-free',
             'Mediterraneo' => 'mediterranean',
             'LibreDeMolusco' => 'mollusk-free',
             'LibreDeMostaza' => 'mustard-free',
             'SinAceite' => 'no-oil-added',
             'DietaPaleo' => 'paleo',
             'LibreDeMani' => 'peanut-free',
             'Pescetariano' => 'pescatarian',
             'LibreDeCerdo' => 'pork-free',
             'LibreDeCarneRoja' => 'red-meat-free',
             'LibreDeSesamo' => 'sesame-free',
             'LibreDeMarisco' => 'shellfish-free',
             'LibreDeSoya' => 'soy-free',
             'AzucarConsciente' => 'sugar-conscious',
             'SinFrutosSecos' => 'tree-nut-free',
             'Vegano' => 'vegan',
             'Vegetariano' => 'vegetarian',
             'LibreDeTrigo' => 'wheat-free',

        ];
    }
}
