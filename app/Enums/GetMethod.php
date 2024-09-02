<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum GetMethod: string
{
    use EnumToArray;
    case Normal = 'Normal';
    case Fao = 'FAO/OMS/ONU';
    case HarrisBenedict = 'Harris-Benedict';
    case Factorial = 'Factorial';
}
