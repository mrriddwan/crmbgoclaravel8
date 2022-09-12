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
                'name' => 'Facebook'
            ],
            [
                'id' => 2,
                'name' => 'Radio'
            ],
            [
                'id' => 3,
                'name' => 'Newspaper'
            ],
            [
                'id' => 4,
                'name' => 'TG-KLTG'
            ],
            [
                'id' => 5,
                'name' => 'TG-KV4L'
            ],
        ]);
    }
}
