<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum ExperienceType: string
{
    use EnumToArray;

    case FormacionAcademica = 'Formación Académica';
    case TrabajoPartTime = 'Trabajo de Tiempo Parcial';
    case TrabajoFullTime = 'Trabajo de Tiempo Completo';
    case Practica = 'Práctica';
    case Voluntariado = 'Voluntariado';
    case ActividadExtracurricular = 'Actividad Extracurricular';

    public static function translation(): array
    {
        return [
        'FormacionAcademica' => 'Formación Académica',
        'TrabajoPartTime' => 'Trabajo de Tiempo Parcial',
        'TrabajoFullTime' => 'Trabajo de Tiempo Completo',
        'Practica' => 'Práctica',
        'Voluntariado' => 'Voluntariado',
        'ActividadExtracurricular' => 'Actividad Extracurricular'
        ];
    }
}
