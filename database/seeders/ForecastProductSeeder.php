<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForecastProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forecast_products')->insert([
            [
                'id' => 1,
                'name' => 'Billboard'
            ],
            [
                'id' => 2,
                'name' => 'Temp Board'
            ],
            [
                'id' => 3,
                'name' => 'Socmed management'
            ],
            [
                'id' => 4,
                'name' => 'Facebook'
            ],
            [
                'id' => 5,
                'name' => 'Travel Guide (Project)'
            ],
            [
                'id' => 6,
                'name' => 'Website Dev'
            ],
            [
                'id' => 7,
                'name' => 'Newspaper'
            ],
            [
                'id' => 8,
                'name' => 'Radio'
            ],
            [
                'id' => 9,
                'name' => 'KLTG'
            ],
            [
                'id' => 10,
                'name' => 'KV4L'
            ],
            [
                'id' => 11,
                'name' => 'e-Catalogue'
            ],
            [
                'id' => 12,
                'name' => 'Bunting'
            ],
        ]);
    }
}
