<?php

namespace Database\Seeders;

use App\Models\Billboard\Tempboard;
use Illuminate\Database\Seeder;

class TempboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tempboard::factory(20)->create();
    }
}
