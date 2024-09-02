<?php

namespace Database\Seeders;

use App\Enums\Food;
use App\Models\FoodIndicator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodIndicatorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = [
            [
                'food' => Food::Cereales,
                'calorias' => 140,
                'cho' => 30,
                'lipidos' => 1,
                'proteinas' => 3,
            ],
            [
                'food' => Food::VerdurasGral,
                'calorias' => 30,
                'cho' => 5,
                'lipidos' => 0,
                'proteinas' => 2,
            ],
            [
                'food' => Food::VerdurasLibreCons,
                'calorias' => 10,
                'cho' => 2.5,
                'lipidos' => 0,
                'proteinas' => 0,
            ],
            [
                'food' => Food::Frutas,
                'calorias' => 65,
                'cho' => 15,
                'lipidos' => 0,
                'proteinas' => 0,
            ],
            [
                'food' => Food::CarnesAG,
                'calorias' => 120,
                'cho' => 1,
                'lipidos' => 8,
                'proteinas' => 11,
            ],
            [
                'food' => Food::CarnesBG,
                'calorias' => 65,
                'cho' => 1,
                'lipidos' => 2,
                'proteinas' => 11,
            ],
            [
                'food' => Food::Legumbres,
                'calorias' => 170,
                'cho' => 30,
                'lipidos' => 0,
                'proteinas' => 11,
            ],
            [
                'food' => Food::LacteosAG,
                'calorias' => 110,
                'cho' => 9,
                'lipidos' => 6,
                'proteinas' => 8,
            ],
            [
                'food' => Food::LacteosMG,
                'calorias' => 85,
                'cho' => 9,
                'lipidos' => 3,
                'proteinas' => 5,
            ],
            [
                'food' => Food::LacteosBG,
                'calorias' => 70,
                'cho' => 10,
                'lipidos' => 0,
                'proteinas' => 7,
            ],
            [
                'food' => Food::AyG,
                'calorias' => 180,
                'cho' => 0,
                'lipidos' => 20,
                'proteinas' => 0,
            ],
            [
                'food' => Food::AlimRicosLipidos,
                'calorias' => 175,
                'cho' => 0,
                'lipidos' => 15,
                'proteinas' => 5,
            ],
            [
                'food' => Food::Azucares,
                'calorias' => 20,
                'cho' => 5,
                'lipidos' => 0,
                'proteinas' => 0,
            ],
        ];

        foreach ($list as $k => $item) {
            FoodIndicator::create($item);
        }
    }
}
