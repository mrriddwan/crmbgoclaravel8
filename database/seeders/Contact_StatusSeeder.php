<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Contact_StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_statuses')->insert([
            [
                'id' => 1,
                'name' => 'BP Existing'
            ],
            [
                'id' => 2,
                'name' => 'BP Raw'
            ],
            [
                'id' => 3,
                'name' => 'BP Potential'
            ],
            [
                'id' => 4,
                'name' => 'Agency'
            ],
            [
                'id' => 5,
                'name' => 'Contractor'
            ],
        ]);
    }
}
