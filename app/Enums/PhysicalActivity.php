<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PhysicalActivity: string
{
    use EnumToArray;

    case leve = 'Leve';
    case moderada = 'Moderada';
    case pesada = 'Pesada';
}


