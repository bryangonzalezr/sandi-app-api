<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum ExperienceType: string
{
    use EnumToArray;

    case FormacionAcademica = 'Formación Académica';
    case TrabajoPartTime = 'Trabajo de Tiempo Parcial';
    case TrabajoFullTime = 'Trabajo de Tiempo Completo';
    case Practica = 'Practica';
    case Voluntariado = 'Voluntariado';
    case ActividadExtracurricular = 'Actividad Extracurricular';
}
