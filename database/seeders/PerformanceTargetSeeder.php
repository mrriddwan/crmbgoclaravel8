<?php

namespace Database\Seeders;

use App\Models\Performance\PerformanceTarget;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerformanceTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PerformanceTarget::factory(30)->create();

        DB::table('performance_targets')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'action_id'=> 1,
                'action_target' => 10,
                'target_remark' => "test",
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'action_id'=> 2,
                'action_target' => 30,
                'target_remark' => "test2",
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'action_id'=> 3,
                'action_target' => 25,
                'target_remark' => "test",
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'action_id'=> 4,
                'action_target' => 22,
                'target_remark' => "test",
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'action_id'=> 5,
                'action_target' => 16,
                'target_remark' => "test",
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'action_id'=> 6,
                'action_target' => 54,
                'target_remark' => "test",
            ],
            [
                'id' => 7,
                'user_id' => 2,
                'action_id'=> 1,
                'action_target' => 33,
                'target_remark' => "test",
            ],
            [
                'id' => 8,
                'user_id' => 2,
                'action_id'=> 2,
                'action_target' => 44,
                'target_remark' => "test",
            ],
            [
                'id' => 9,
                'user_id' => 2,
                'action_id'=> 3,
                'action_target' => 17,
                'target_remark' => "test",
            ],
            [
                'id' => 10,
                'user_id' => 2,
                'action_id'=> 4,
                'action_target' => 19,
                'target_remark' => "test",
            ],
            [
                'id' => 11,
                'user_id' => 2,
                'action_id'=> 5,
                'action_target' => 25,
                'target_remark' => "test",
            ],
            [
                'id' => 12,
                'user_id' => 2,
                'action_id'=> 6,
                'action_target' => 70,
                'target_remark' => "test",
            ],
            [
                'id' => 13,
                'user_id' => 3,
                'action_id'=> 2,
                'action_target' => 69,
                'target_remark' => "test",
            ],
            [
                'id' => 14,
                'user_id' => 3,
                'action_id'=> 6,
                'action_target' => 420,
                'target_remark' => "test",
            ],
        ]);
    }
}
