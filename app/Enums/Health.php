<?php

namespace App\Enums;

enum Health: string
{
    case alcohol_cocktail = 'alcohol-cocktail';
    case LibreDeAlcohol = 'alcohol-free';
    case LibreDeCrustaceos = 'crustacean-free';
    case LibreDeLacteos = 'dairy-free';
    case LibreDeLactosa = 'egg-free';
    case LibreDePescado = 'fish-free';
    case LibreDeGluten = 'gluten-free';
    case KetoAmigable = 'keto-friendly';
    case AptoParaRiñones = 'kidney-friendly';
    case Kosher = 'kosher';
    case low_fat_abs = 'low-fat-abs';
    case BajoEnPotasio = 'low-potassium';
    case BajoEnAzucar = 'low-sugar';
    case LibreDeLupino = 'lupine-free';
    case Mediterraneo = 'mediterranean';
    case LibreDeMolusco = 'mollusk-free';
    case LibreDeMostaza = 'mustard-free';
    case SinAceite = 'no-oil-added';
    case DietaPaleo = 'paleo';
    case LibreDeMani = 'peanut-free';
    case Pescetariano = 'pescatarian';
    case LibreDeCerdo = 'pork-free';
    case LibreDeCarneRojo = 'red-meat-free';
    case LibreDeSesamo = 'sesame-free';
    case LibreDeMarisco = 'shellfish-free';
    case LibreDeSoya = 'soy-free';
    case AzucarConsciente = 'sugar-conscious';
    case SinFrutosSecos = 'tree-nut-free';
    case Vegano = 'vegan';
    case Vegetariano = 'vegetarian';
    case LibreDeTrigo = 'wheat-free';
}
