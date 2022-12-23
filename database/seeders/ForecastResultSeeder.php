<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForecastResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forecast_results')->insert([
            [
                'id' => 1,
                'name' => 'Confirmed'
            ],
            [
                'id' => 2,
                'name' => 'Rejected'
            ],
            [
                'id' => 3,
                'name' => 'Pending'
            ],
            [
                'id' => 100,
                'name' => 'No Result'
            ],
        ]);
    }
}
