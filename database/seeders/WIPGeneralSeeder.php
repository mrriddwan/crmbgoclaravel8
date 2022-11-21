<?php

namespace Database\Seeders;

use App\Models\Tracking\WIPGeneral;
use Illuminate\Database\Seeder;

class WIPGeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WipGeneral::factory(100)->create();
    }
}
