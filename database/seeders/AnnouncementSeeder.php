<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('announcements')->insert([
            [
                'id' => 1,
                'message' => 'Please follow the latest procedure on COVID-19',
                'from_user_id'=> 1,
                'to_user_id'=> null,
                'message_type_id'=> 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'message' => 'To be or not to be',
                'from_user_id'=> 1,
                'to_user_id'=> null,
                'message_type_id'=> 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'message' => 'School holiday not over',
                'from_user_id'=> 1,
                'to_user_id'=> 2,
                'message_type_id'=> 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'message' => 'Momma told me to knock you out',
                'from_user_id'=> 2,
                'to_user_id'=> 1,
                'message_type_id'=> 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'message' => 'HELP',
                'from_user_id'=> 1,
                'to_user_id'=> 3,
                'message_type_id'=> 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
