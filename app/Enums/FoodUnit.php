<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum FoodUnit: string
{
    use EnumToArray;
    case Kilogramos = 'kilogramos';
    case Gramos = 'gramos';
    case Miligramos = 'miligramos';
}
