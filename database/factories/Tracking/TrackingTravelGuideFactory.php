<?php

namespace Database\Factories\Tracking;

use App\Models\Tracking\TrackingTravelGuide;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackingTravelGuideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrackingTravelGuide::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => random_int(1, 10),
            'company_id' => random_int(1, 50),
            'edition' => $this->faker->realText(10),
            'tguide_size' => $this->faker->realText(10),
            'tguide_remark' => $this->faker->realText(10),
        ];
    }
}
