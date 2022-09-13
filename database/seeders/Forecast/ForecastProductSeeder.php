<?php

namespace Database\Seeders\Forecast;

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
                'name' => 'Online'
            ],
            [
                'id' => 4,
                'name' => 'Social Media'
            ],
            [
                'id' => 5,
                'name' => 'Travel Guide'
            ],
        ]);
    }
}
