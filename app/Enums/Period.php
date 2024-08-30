<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum Period: string
{
    use EnumToArray;
    case Mensual = 'Mensual';
    case Anual   = 'Anual';
}
