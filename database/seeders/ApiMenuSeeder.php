<?php

namespace Database\Seeders;

use App\Models\ApiMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tokens = [
            [
                "08cc96e5",
                "9c8cbf501dd89320c5f4f29fde553f99"
            ],
            [
                "20cb953b",
                "8fe6dfde7cf1367c15210d5d4a71ed0b"
            ],
            [
                "c62edd1e",
                "5291547a50f04df37c1538c49fcce2b4"
            ],
            [
                "d6d63017",
                "76af779ee7be383ca87791752ba3b97e"
            ],
            [
                "36be0ae6",
                "812b4692cbfba8ca77410921c0d29bea"
            ],
            [
                "bc2419e8",
                "37d381e462fe6118168b95915b51ac35"
            ],
            [
                "c71a1471",
                "b1b3462cb0c0a306aff14e4932d5a84d"
            ],
            [
                "ecdfe56e",
                "4b2c6e940893b987ca1a70c7e43e63eb"
            ]
        ];

        foreach ($tokens as $token) {
            ApiMenu::create([
                'api_id' => $token[0],
                'api_key' => $token[1],
            ]);
        }
    }
}
