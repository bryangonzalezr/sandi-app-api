<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum TimeUnit: string
{
    use EnumToArray;
    case Años = 'años';
    case Meses = 'meses';
    case Días = 'días';
    case Horas = 'horas';
}
