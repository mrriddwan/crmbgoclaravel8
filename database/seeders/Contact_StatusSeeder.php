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
                'name' => 'Existing'
            ],
            [
                'id' => 2,
                'name' => 'Raw New'
            ],
            [
                'id' => 3,
                'name' => 'Potential'
            ],
            [
                'id' => 4,
                'name' => 'KLTG Raw'
            ],
            [
                'id' => 5,
                'name' => 'KLTG Potential'
            ],
            [
                'id' => 6,
                'name' => 'KLTG Existing'
            ],
            [
                'id' => 7,
                'name' => 'KV4L Raw'
            ],
            [
                'id' => 8,
                'name' => 'KV4L Potential'
            ],
            [
                'id' => 9,
                'name' => 'KV4L Existing'
            ],
        ]);
    }
}
