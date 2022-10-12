<?php

namespace Database\Factories\Billboard;

use App\Models\Billboard\BillboardTenure;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillboardTenureFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BillboardTenure::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tenure_startdate = $this->faker->dateTimeThisYear('+1 week');
        $tenure_enddate = $this->faker->dateTimeBetween($tenure_startdate->format('Y-m-d'), $tenure_startdate->format('Y-m-d') . '+12 months');

        return [
            'tenure_startdate' => $tenure_startdate,
            'tenure_enddate' => $tenure_enddate,
            'bboard_id' => random_int(1, 20),
            'contact_id' => random_int(1, 100),
            'user_id' => random_int(3, 10),
        ];
    }
}
