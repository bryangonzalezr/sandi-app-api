<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum NutritionalState: string
{
    use EnumToArray;
    case Enflaquecido = 'Enflaquecido';
    case Normal = 'Normal';
    case Sobrepeso = 'Sobrepeso';
    case Obesidad = 'Obesidad';
}
