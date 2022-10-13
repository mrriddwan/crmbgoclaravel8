<?php

namespace Database\Factories\Billboard;

use App\Models\Billboard\Tempboard;
use Illuminate\Database\Eloquent\Factories\Factory;

class TempboardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tempboard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tpboard_startdate = $this->faker->dateTimeThisYear('+1 week');
        $tpboard_enddate = $this->faker->dateTimeBetween($tpboard_startdate->format('Y-m-d'), $tpboard_startdate->format('Y-m-d') . '+12 months');
        $tpboard_height = $this->faker->numberBetween(0, 100);
        $tpboard_length = $this->faker->numberBetween(0, 100);

        return [
            'tpboard_entrydate' => $tpboard_startdate,
            'tpboard_startdate' => $tpboard_startdate,
            'tpboard_enddate' => $tpboard_enddate,
            'contact_id' => random_int(1, 100),
            'user_id' => random_int(1, 10),
            'tpboard_size' => $tpboard_height . "x" . $tpboard_length,
            'tpboard_location' => $this->faker->city(),
            'tpboard_unit' => $this->faker->randomDigitNotNull(),
            'tpboard_collection'=> $this->faker->realText($maxNbChars = 10),
            'tpboard_material'=> $this->faker->realText($maxNbChars = 10),
            'tpboard_printing'=> $this->faker->realText($maxNbChars = 10),
            'tpboard_installation' => $this->faker->realText($maxNbChars = 20),
            'tpboard_remark' => $this->faker->realText($maxNbChars = 20),
        ];
    }
}
