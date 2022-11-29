<?php

namespace Database\Factories\Tracking;

use App\Models\Tracking\WipTravelGuide;
use Illuminate\Database\Eloquent\Factories\Factory;

class WIPTravelGuideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WipTravelGuide::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $date = $this->faker->dateTimeThisYear('+6 months');

        return [
            'tracking_tguide_id'=> random_int(1, 20),
            'wip_assignment_date' => $date,
            'wip_assignment_done' => random_int(1,2),
            'wip_assignment_user_id'=> random_int(1, 10),
            'wip_assignment_remark' => $this->faker->realText(10),
        ];
    }
}
