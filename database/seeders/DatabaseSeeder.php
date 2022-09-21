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
            UserSeeder::class,
            Contact_TypeSeeder::class,
            Contact_StatusSeeder::class,
            Contact_CategorySeeder::class,
            Contact_IndustrySeeder::class,
            ContactSeeder::class,
            TaskSeeder::class,
            PrioritySeeder::class,
            TextColorSeeder::class,
            ActionSeeder::class,
            ToDoSourceSeeder::class,
            ForecastProductSeeder::class,
            ForecastResultSeeder::class,
            ForecastSeeder::class,
            Contact_InchargeSeeder::class,
            ToDoSeeder::class,
            FollowUpSeeder::class,
            ProjectSeeder::class,

        ]);
    }
}
