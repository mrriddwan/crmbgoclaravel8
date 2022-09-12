<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            [
                'id' => 1,
                'name' => 'Appointment Visitation'
            ],
            [
                'id' => 2,
                'name' => 'Attended'
            ],
            [
                'id' => 3,
                'name' => 'Call'
            ],
            [
                'id' => 4,
                'name' => 'Carried Forward'
            ],
            [
                'id' => 5,
                'name' => 'Prepare Proposal'
            ],
        ]);
    }
}
