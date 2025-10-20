<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum Food: string
{
    use EnumToArray;

    case Cereales = 'Cereales';
    case VerdurasGral = 'Verduras en General';
    case VerdurasLibreCons = 'Verduras Libres de Consumo';
    case Frutas = 'Frutas';
    case CarnesAG = 'Carnes Altas en Grasa';
    case CarnesBG = 'Carnes Bajas en Grasa';
    case Legumbres = 'Legumbres';
    case LacteosAG = 'Lacteos Altos en Grasa';
    case LacteosMG = 'Lacteos Medios en Grasa';
    case LacteosBG = 'Lacteos Bajos en Grasa';
    case AyG = 'Aceites y Grasas';
    case AlimRicosLipidos = 'Alimentos Ricos en Lipidos';
    case Azucares = 'Azucares';

}
