<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum UserSex: string
{
    use EnumToArray;
    case Masculino = 'Masculino';
    case Femenino = 'Femenino';
}
