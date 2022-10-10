<?php

namespace Database\Seeders;

use App\Models\Billboard\Billboard;
use Illuminate\Database\Seeder;

class BillboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Billboard::factory(200)->create();
    }
}
