<?php

namespace Database\Seeders;

use App\Models\Forecast\Forecast;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForecastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Forecast::factory(10)->create();
    }
}
