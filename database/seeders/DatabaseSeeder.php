<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Billboard\Billboard;
use App\Models\Billboard\BillboardTenure;
use App\Models\Billboard\Tempboard;
use App\Models\Forecast\ForecastType;
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
            ForecastTypeSeeder::class,
            ForecastSeeder::class,
            Contact_InchargeSeeder::class,
            ToDoSeeder::class,
            FollowUpSeeder::class,
            ProjectSeeder::class,
            BillboardSeeder::class,
            TempboardSeeder::class,
            BillboardTenureSeeder::class,
        ]);
    }
}
