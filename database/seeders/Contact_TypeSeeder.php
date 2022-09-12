<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Contact_TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_types')->insert([
            [
                'id' => 1,
                'name' => 'A1'
            ],
            [
                'id' => 2,
                'name' => 'A2'
            ],
            [
                'id' => 3,
                'name' => 'Potential'
            ],
            [
                'id' => 4,
                'name' => 'Raw'
            ],
            [
                'id' => 5,
                'name' => 'Reject'
            ],
        ]);
    }
}
