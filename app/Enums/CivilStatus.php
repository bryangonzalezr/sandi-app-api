<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum CivilStatus: string
{
    use EnumToArray;

    case Soltero = 'Soltero(a)';
    case Divorciado = 'Divorciad(a)';
    case Viudo = 'Viudo(a)';
    case Casado = 'Casado(a)';
    case ConvivienteCivil = 'Conviviente civil';
}
