<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForecastTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forecast_types')->insert([
            [
                'id' => 1,
                'name' => 'A1'
            ],
            [
                'id' => 2,
                'name' => 'A2'
            ],
            [
                'id' => 3,
                'name' => 'PL'
            ],
            [
                'id' => 4,
                'name' => 'UL'
            ],
        ]);
    }
}
