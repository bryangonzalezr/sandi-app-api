<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum DietLabels: string
{
    use EnumToArray;

    case BajoEnCarbohidratos = 'low-carb';
    case BajoEnGrasa = 'low-fat';

    case BajoEnSodio = 'low-sodium';

    case Balanceado = 'balanced';

    case AltoEnFibra = 'high-fiber';

    case AltoEnProteina = 'high-protein';

    public static function translation(): array
    {
        return [
            'BajoEnCarbohidratos' => 'Bajo en Potasio',
            'BajoEnGrasa' => 'Bajo en Azucar',
            'BajoEnSodio' => 'Bajo en Sodio',
            'Balanceado' => 'Balanceado',
            'AltoEnFibra' => 'Alto en Fibra',
            'AltoEnProteina' => 'Alto en Proteina',
        ];
    }
}
