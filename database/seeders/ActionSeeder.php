<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actions')->insert([
            [
                'id' => 1,
                'name' => 'Appointment Visitation'
            ],
            [
                'id' => 2,
                'name' => 'Approval obtained'
            ],
            [
                'id' => 3,
                'name' => 'Attended'
            ],
            [
                'id' => 4,
                'name' => 'Payment'
            ],
            [
                'id' => 5,
                'name' => 'Carried Forward'
            ],
            [
                'id' => 6,
                'name' => 'Called'
            ],
        ]);
    }
}
