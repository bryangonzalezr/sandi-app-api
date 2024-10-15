<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum DishType: string
{
    use EnumToArray;

    case CocktailDeAlcohol = 'Cocktail de Alcohol';
    case BizcochosYGalletas= 'Bizcochos y Galletas';

    case Pan = 'Pan';

    case Cereales = 'Cereales';

    case CondimentosYSalsas = 'Condimentos y Salsas';

    case Postres = 'Postres';

    case Bebidas = 'Bebidas';

    case Huevo = 'Huevo';

    case HeladoYFlan = 'Helado y Flan';

    case PlatoPrincipal = 'Plato principal';

    case Panqueque = 'Panqueque';

    case Pasta = 'Pasta';

    case Pasteleria = 'Pasteleria';

    case PiesYTartas = 'Pies Y Tartas';

    case Pizza = 'Pizza';

    case Preparativos = 'Preparativos';

    case Conserva = 'Conserva';

    case Ensalada = 'Ensalada';

    case Sandwiches = 'Sandwiches';

    case ComidaMarina = 'Comida Marina';

    case Guarniciones = 'Guarniciones';

    case Sopa = 'Sopa';

    case OcasionesEspeciales = 'Ocasiones Especiales';

    case Entrada = 'Entrada';

    case Dulces = 'Dulces';
}
