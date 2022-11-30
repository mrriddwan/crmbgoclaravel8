<?php

namespace Database\Seeders;

use App\Models\Tracking\TrackingTravelGuide;
use Illuminate\Database\Seeder;

class TrackingTGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrackingTravelGuide::factory(300)->create();
    }
}
