<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum MealType: string
{
    use EnumToArray;
    case desayuno = 'breakfast';
    case almuerzo = 'lunch';
    case cena = 'dinner';
}
