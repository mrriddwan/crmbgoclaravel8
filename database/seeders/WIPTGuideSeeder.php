<?php

namespace Database\Seeders;

use App\Models\Tracking\WipGeneral;
use App\Models\Tracking\WipTravelGuide;
use Illuminate\Database\Seeder;

class WIPTGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WipTravelGuide::factory(300)->create();
    }
    
}
