<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PatientType: string
{
    use EnumToArray;
    case Ambulatorio = 'Ambulatorio';
    case Enfermo = 'Enfermo';
}
