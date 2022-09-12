<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToDoSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('to_do_sources')->insert([
            [
                'id' => 1,
                'name' => 'Contact'
            ],
            [
                'id' => 2,
                'name' => 'Follow Up'
            ],
            [
                'id' => 3,
                'name' => 'Internal'
            ],
        ]);
    }
}
