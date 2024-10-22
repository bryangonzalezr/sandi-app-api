<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CommuneSeeder extends Seeder
{
    public function run(): void
    {
        DB::unprepared(Storage::get('seeds/comunas.sql'));
    }
}
