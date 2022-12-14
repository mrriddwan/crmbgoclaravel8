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
        $a = array(1, 2, 3, null);
        $random_keys=array_rand($a,3);

        return [
            'amount' => $this->faker->numberBetween(10000, 50000),
            'forecast_date' => $this->faker->dateTimeBetween('-8 months', '+11 months'),
            'result_id' => $a[$random_keys[0]],
            'forecast_updatedate' => $this->faker->dateTimeBetween('-1 week', '+3 months'),
            'user_id' => random_int(1, 10),
            'contact_id' => random_int(1, 100),
            'forecast_type_id' => random_int(1, 4),
            'product_id' => random_int(1, 5),
            'contact_status_id' => random_int(1, 5),
            'contact_type_id' => random_int(1, 5),
        ];
    }
}
