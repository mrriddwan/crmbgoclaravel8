<?php

namespace Database\Factories\Billboard;

use App\Models\Billboard\Billboard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\ms_MY\Address;

class BillboardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Billboard::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $bboard_height = $this->faker->numberBetween(0, 100);
        $bboard_length = $this->faker->numberBetween(0, 100);
        $site_id = ($this->faker->numberBetween(1, 10))." - ".($this->faker->countryCode());
        // $todo_date = $this->faker->dateTimeThisYear('+1 week');
        // $todo_deadline = $this->faker->dateTimeBetween($todo_date->format('Y-m-d'),$todo_date->format('Y-m-d') . '+12 months');
        return [
            'site_id' => $site_id,
            'bboard_location' => $this->faker->city(),
            'bboard_size' => $bboard_height . " x " . $bboard_length,
        ];
    }
}
