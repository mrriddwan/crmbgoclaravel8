<?php

namespace Database\Factories\Project;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\CarbonInterval;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $project_startdate = $this->faker->dateTimeBetween('+0 days', '+1 month');
        $project_enddate = $this->faker->dateTimeBetween(
            $project_startdate->format('Y-m-d'),
            $project_startdate->format('Y-m-d') . '+11 months');
        
        // $project_duration = $project_enddate ->diff($project_startdate);
        // $project_duration->format('%a');

        return [
            'project_startdate' =>  $project_startdate,
            'project_enddate' => $project_enddate,
            // 'project_duration' => $project_duration,
            'project_name' => $this->faker->realText($maxNbChars = 15),
            'project_remark' => $this->faker->realText($maxNbChars = 50),
            'contact_id' => random_int(1, 100),
            'user_id' => random_int(2, 10),
        ];
    }
}
