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
        $date = $this->faker->dateTimeThisYear('+3 months');

        return [
            'user_id' => random_int(1, 10),
            'company_id' => random_int(1, 50),
            'edition' => $this->faker->realText(10),
            'tguide_size' => $this->faker->realText(10),
            'tguide_remark' => $this->faker->realText(10),
            'art_reminder_date' => $date,
            'art_reminder_remark'=> $this->faker->realText(10),
            'art_reminder_done' => random_int(1, 2),
            'art_reminder_user_id' => random_int(1, 10),
            'art_record_date' => $date,
            'art_record_remark'=> $this->faker->realText(10),
            'art_record_done' => random_int(1, 2),
            'art_record_user_id' => random_int(1, 10),
        ];
    }
}
