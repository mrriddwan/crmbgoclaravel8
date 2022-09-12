<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert([
            [
                'id' => 1,
                'name' => 'Urgent'
            ],
            [
                'id' => 2,
                'name' => 'Not Urgent'
            ],
        ]);
    }
}
