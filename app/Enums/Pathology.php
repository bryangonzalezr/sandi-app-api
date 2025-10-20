<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum Pathology: string
{
    use EnumToArray;
    case HiperMetabolismoLeve = 'HiperMetabolismo Leve';
    case HiperMetabolismoModerado = 'HiperMetabolismo Moderado';
    case HiperMetabolismo = 'HiperMetabolismo';
    case EdemaSevero = 'Edema Severo';
    case Ascitis = 'Ascitis';
    case DesnutricionLeve = 'Desnutrición Leve';
    case DesnutricionModerada = 'Desnutrición Moderada';
    case DesnutricionSevera = 'Desnutrición Severa';
    case DesnutricionSinEstres = 'Desnutrición Sin Estrés';
    case Tumor = 'Tumor';
    case LeucemiaLinfoma = 'Leucemia / Linfoma';
    case Infeccion = 'Infeccion';
    case SepsisAbscesos = 'Sepsis / Abscesos';
    case Quemadura20 = 'Quemadura 20%';
    case Quemadura40 = 'Quemadura 20-40%';
    case Quemadura100 = 'Quemadura 40-100%';
    case EnfermedadPancreatica = 'Enfermedad Pancreática';
    case EnfermedadInfamatoriaIntestinal = 'Enfermedad Inflamatoria Intestinal';
    case CirugiaMenor = 'Cirugia Menor';
    case CirugiaMayor = 'Cirugia Mayor';
    case CirugiaGeneral = 'Cirugia General';
    case Politraumatismo = 'Politraumatismo';
    case PolitraumatismoSepsis = 'Politraumatismo y Sepsis';
    case Transplante = 'Transplante';
    case VentilacionMecanica = 'Ventilación Mecanica';


}
