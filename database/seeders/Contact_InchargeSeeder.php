<?php

namespace Database\Seeders;

use App\Models\ContactIncharge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Contact_InchargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactIncharge::factory(1)->create();
    }
}
