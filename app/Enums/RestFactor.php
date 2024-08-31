<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum RestFactor: string
{
    use EnumToArray;
    case Absoluto = 'Absoluto';
    case Relativo = 'Relativo';
    case Ambulatorio = 'Ambulatorio';
}
