<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PatientType: string
{
    use EnumToArray;
    case Ambulatorio = 'Ambulatorio';
    case Hospitalizado = 'Hospitalizado';
    case Enfermo = 'Enfermo';
    case Sano = 'Sano';
}
