<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Contact_CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_categories')->insert([
            [
                'id' => 1,
                'name' => 'KLTG Food'
            ],
            [
                'id' => 2,
                'name' => 'KLTG Attraction'
            ],
            [
                'id' => 3,
                'name' => 'KLTG Accomodation'
            ],
            [
                'id' => 4,
                'name' => 'KV4L Food'
            ],
            [
                'id' => 5,
                'name' => 'KV4L Attraction'
            ],
            [
                'id' => 6,
                'name' => 'KV4L Accomodation'
            ],
        ]);
    }
}
