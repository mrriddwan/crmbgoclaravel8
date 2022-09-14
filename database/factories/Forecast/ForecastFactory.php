<?php

namespace Database\Factories\Forecast;

use App\Models\Forecast\Forecast;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForecastFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Forecast::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->numberBetween(10000, 50000),
            'forecast_date' => $this->faker -> dateTimeBetween('-2 week', '+1 week'),
            'result_id' => random_int(1,2),
            'forecast_updatedate' => $this->faker -> dateTimeBetween('-1 week', '+3 months'),
            'user_id' => random_int(2,10),
            'contact_id' => random_int(1,5),
            'type_id' => random_int(1,5),
            'product_id' => random_int(1,5),
        ];
    }
}
