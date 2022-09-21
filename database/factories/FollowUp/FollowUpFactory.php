<?php

namespace Database\Factories\FollowUp;

use App\Models\FollowUp\FollowUp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FollowUp>
 */
class FollowUpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FollowUp::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'followup_created' => $this->faker ->dateTimeThisYear('+2 month'),
            'followup_time' => $this->faker ->time($format = 'H:i', $max = 'now'),
            'followup_remark' => $this->faker ->realText($maxNbChars = 50),
            'todo_id' => random_int(1, 150),
            'contact_id' => random_int(1, 100),
            'user_id' => random_int(2, 10),
            'task_id' => random_int(1, 5),
            'status_id' => random_int(1, 5),
            'type_id' => random_int(1, 5),
            'priority_id' => random_int(1, 2),
        ];
    }
}
