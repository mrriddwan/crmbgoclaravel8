<?php

namespace Database\Factories\Tracking;

use App\Models\Tracking\WipGeneral;
use Illuminate\Database\Eloquent\Factories\Factory;

class WIPGeneralFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WipGeneral::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeThisYear('+3 months');

        return [
            'tracking_general_id' => random_int(1, 10),
            'frequency_no' => random_int(1, 6),
            'art_chase_date' => $date,
            'art_chase_remark' => $this->faker->realText(15),
            'art_chase_user_id' => random_int(1, 6),
            'art_received_date' => $date,
            'art_received_remark' => $this->faker->realText(15),
            'art_received_user_id' => random_int(1, 6),
            'art_todo_date' => $date,
            'art_todo_remark' => $this->faker->realText(15),
            'art_todo_user_id' => random_int(1, 6),
            'c&s_sent_date' => $date,
            'c&s_sent_remark' => $this->faker->realText(15),
            'c&s_sent_user_id' => random_int(1, 6),
            'c&s_record_date' => $date,
            'c&s_record_remark' => $this->faker->realText(15),
            'c&s_record_user_id' => random_int(1, 6),
            'schedule_date' => $date,
            'schedule_remark' => $this->faker->realText(15),
            'schedule_user_id' => random_int(1, 6),
            'live_date' => $date,
            'live_remark' => $this->faker->realText(15),
            'live_user_id' => random_int(1, 6),
            'client_posting_date' => $date,
            'client_posting_user_id' => random_int(1, 6),
            'client_posting_remark' => $this->faker->realText(15),
            'report_date' => $date,
            'report_remark' => $this->faker->realText(15),
            'report_user_id' => random_int(1, 6),
        ];
    }
}
