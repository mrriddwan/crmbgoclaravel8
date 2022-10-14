<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCategoryBenchmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_category_benchmarks')->insert([
            [
                'id' => 1,
                'user_cat_id' => random_int(1,3),
                'task_id' => random_int(1,7),
                'task_target' => random_int(10,30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'user_cat_id' => random_int(1,3),
                'task_id' => random_int(1,7),
                'task_target' => random_int(10,30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'user_cat_id' => random_int(1,3),
                'task_id' => random_int(1,7),
                'task_target' => random_int(10,30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'user_cat_id' => random_int(1,3),
                'task_id' => random_int(1,7),
                'task_target' => random_int(10,30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'user_cat_id' => random_int(1,3),
                'task_id' => random_int(1,7),
                'task_target' => random_int(10,30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 6,
                'user_cat_id' => random_int(1,3),
                'task_id' => random_int(1,7),
                'task_target' => random_int(10,30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 7,
                'user_cat_id' => random_int(1,3),
                'task_id' => random_int(1,7),
                'task_target' => random_int(10,30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],

        ]);
    }
}
