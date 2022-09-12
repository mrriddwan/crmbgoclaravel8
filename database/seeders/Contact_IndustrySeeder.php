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
                'name' => 'Developer'
            ],
            [
                'id' => 3,
                'name' => 'Entertainment'
            ],
            [
                'id' => 4,
                'name' => 'F&B'
            ],
            [
                'id' => 5,
                'name' => 'Education'
            ],
        ]);
    }
}
