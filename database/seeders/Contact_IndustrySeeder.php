<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Contact_IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_industries')->insert([
            [
                'id' => 1,
                'name' => 'Beauty and Health'
            ],
            [
                'id' => 2,
                'name' => 'F&B'
            ],
            [
                'id' => 3,
                'name' => 'Education'
            ],
            [
                'id' => 4,
                'name' => 'Medical'
            ],
            [
                'id' => 5,
                'name' => 'Shopping'
            ],
            [
                'id' => 6,
                'name' => 'Retails'
            ],
            [
                'id' => 7,
                'name' => 'Fashion'
            ],
            [
                'id' => 8,
                'name' => 'Home'
            ],
            [
                'id' => 9,
                'name' => 'Properties'
            ],
            [
                'id' => 10,
                'name' => 'Services'
            ],
            [
                'id' => 11,
                'name' => 'Gov Bodies'
            ],
            [
                'id' => 12,
                'name' => 'Agencies'
            ],
            [
                'id' => 13,
                'name' => 'Transportation & Automative'
            ],
            [
                'id' => 14,
                'name' => 'Industrial & Manufacturing'
            ],
            [
                'id' => 15,
                'name' => 'Finance'
            ],
            [
                'id' => 16,
                'name' => 'Exhibitions'
            ],
        ]);
    }
}
