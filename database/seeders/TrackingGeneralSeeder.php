<?php

namespace Database\Seeders;

use App\Models\Tracking\TrackingGeneral;
use Illuminate\Database\Seeder;

class TrackingGeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrackingGeneral::factory(100)->create();
    }
}
