<?php

namespace Database\Seeders;

use App\Models\Billboard\BillboardTenure;
use Illuminate\Database\Seeder;

class BillboardTenureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BillboardTenure::factory(100)->create();
    }
}
