<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum HabitFrequency: string
{
    use EnumToArray;
    case Nada = 'Nada';
    case Poco = 'Poco';
    case Moderado = 'Moderado';
    case Alto = 'Alto';
}
