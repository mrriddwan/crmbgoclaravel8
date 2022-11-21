<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserCategorySeeder::class,
            TaskSeeder::class,
            ActionSeeder::class,
            UserCategoryBenchmarkSeeder::class,
            UserSeeder::class,
            SupervisorSeeder::class,
            SV_SB_Seeder::class,
            RolesAndPermissionSeeder::class,
            Contact_TypeSeeder::class,
            Contact_StatusSeeder::class,
            Contact_CategorySeeder::class,
            Contact_IndustrySeeder::class,
            ContactSeeder::class,
            PrioritySeeder::class,
            TextColorSeeder::class,
            ToDoSourceSeeder::class,
            ForecastProductSeeder::class,
            ForecastResultSeeder::class,
            ForecastTypeSeeder::class,
            ForecastSeeder::class,
            Contact_InchargeSeeder::class,
            ToDoSeeder::class,
            FollowUpSeeder::class,
            ProjectSeeder::class,
            BillboardSeeder::class,
            TempboardSeeder::class,
            BillboardTenureSeeder::class,
            TrackingGeneralSeeder::class,
            WIPGeneralSeeder::class,
        ]);
    }
}
