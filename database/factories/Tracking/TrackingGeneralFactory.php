<?php

namespace Database\Factories\Tracking;

use App\Models\Forecast\ForecastResult;
use App\Models\Tracking\TrackingGeneral;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackingGeneralFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrackingGeneral::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $track_startdate = $this->faker->dateTimeThisYear('+3 months');
        $track_enddate = $this->faker->dateTimeBetween($track_startdate->format('Y-m-d'), $track_startdate->format('Y-m-d') . '+12 months');

        return [
            'progress' => 'Pending',
            'track_startdate' => $track_startdate,
            'track_enddate' => $track_enddate,
            'user_id' => random_int(1, 10),
            'company_id' => random_int(1, 10),
            'contact_category_id' => random_int(1, 5),
            'category_description' => $this->faker->realText(100),
            'art_frequency' => random_int(1, 6),
            'tracking_type' => $this->faker->realText(10),
            'general_reach' => $this->faker->realText(15),
            'general_tenure' => $this->faker->realText(15),
            'art_format' => $this->faker->realText(15),
            'general_amount' => $this->faker->numberBetween(1000, 10000),
            'general_remark' => $this->faker->realText(15),
        ];
    }
}
