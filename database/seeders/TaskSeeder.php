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
                'name' => 'Call'
            ],
            [
                'id' => 2,
                'name' => 'Attended (others)'
            ],
            [
                'id' => 3,
                'name' => 'Appointment Visitation'
            ],
            [
                'id' => 4,
                'name' => 'Carried Forward'
            ],
            [
                'id' => 5,
                'name' => 'Proposal Preparation'
            ],
            [
                'id' => 6,
                'name' => 'Email Blast'
            ],
            [
                'id' => 7,
                'name' => 'Whatsapp Blast'
            ],
        ]);
    }
}
