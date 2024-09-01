<?php

namespace Database\Seeders;

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
                'food' => 'Cereales',
                'calorias' => 140,
                'cho' => 30,
                'lipidos' => 1,
                'proteinas' => 3,
            ],
            [
                'food' => 'V. en gral',
                'calorias' => 30,
                'cho' => 5,
                'lipidos' => 0,
                'proteinas' => 2,
            ],
            [
                'food' => 'V. libre cons.',
                'calorias' => 10,
                'cho' => 2.5,
                'lipidos' => 0,
                'proteinas' => 0,
            ],
            [
                'food' => 'Frutas',
                'calorias' => 65,
                'cho' => 15,
                'lipidos' => 0,
                'proteinas' => 0,
            ],
            [
                'food' => 'Carnes AG',
                'calorias' => 120,
                'cho' => 1,
                'lipidos' => 8,
                'proteinas' => 11,
            ],
            [
                'food' => 'Carnes BG',
                'calorias' => 65,
                'cho' => 1,
                'lipidos' => 2,
                'proteinas' => 11,
            ],
            [
                'food' => 'Leg',
                'calorias' => 170,
                'cho' => 30,
                'lipidos' => 0,
                'proteinas' => 11,
            ],
            [
                'food' => 'Lact. AG',
                'calorias' => 110,
                'cho' => 9,
                'lipidos' => 6,
                'proteinas' => 8,
            ],
            [
                'food' => 'Lact. MG',
                'calorias' => 85,
                'cho' => 9,
                'lipidos' => 3,
                'proteinas' => 5,
            ],
            [
                'food' => 'Lact. BG',
                'calorias' => 70,
                'cho' => 10,
                'lipidos' => 0,
                'proteinas' => 7,
            ],
            [
                'food' => 'A y G',
                'calorias' => 180,
                'cho' => 0,
                'lipidos' => 20,
                'proteinas' => 0,
            ],
            [
                'food' => 'Alim ricos lip',
                'calorias' => 175,
                'cho' => 0,
                'lipidos' => 15,
                'proteinas' => 5,
            ],
            [
                'food' => 'Azúcar',
                'calorias' => 20,
                'cho' => 5,
                'lipidos' => 0,
                'proteinas' => 0,
            ],
        ];

        foreach ($list as $item) {
            FoodIndicator::create($item);
        }
    }
}
