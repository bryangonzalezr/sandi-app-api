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
                "c195c2ff",
                "27c970d4b9549791d894c768942eb022"
            ],
            [
                "6b8f20a1",
                "4ede376307df124ee48272ca5bbf1150"
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
