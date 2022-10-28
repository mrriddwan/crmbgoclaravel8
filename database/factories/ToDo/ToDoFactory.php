<?php

namespace Database\Factories\ToDo;

use App\Models\ToDo\ToDo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ToDo>
 */
class ToDoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ToDo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +2 days');
        $todo_date = $this->faker->dateTimeThisYear('-1 days');
        $todo_deadline = $this->faker->dateTimeBetween($todo_date->format('Y-m-d'),$todo_date->format('Y-m-d') . '+12 months');
        // $todo_deadline = $this->faker->dateTimeBetween($todo_date->format('Y-m-d H:i:s'),$todo_date->format('Y-m-d H:i:s') . '+12 months');

        // $end_date = $this->faker->dateTimeBetween(
        //     $start_date->format('Y-m-d H:i:s') . ' +3 days',
        //     $start_date->format('Y-m-d H:i:s') . ' +3 days'
        // );

        return [
            'todo_date' => $todo_date,
            'todo_deadline' => $todo_deadline,
            'todo_remark' => $this->faker->realText(100),
            'contact_id' => random_int(1, 50),
            'user_id' => random_int(1, 10),
            'task_id' => random_int(1, 5),
            'status_id' => random_int(1, 5),
            'type_id' => random_int(1, 5),
            'priority_id' => random_int(1, 2),
            'color_id' => random_int(1, 5),
            'action_id' => random_int(1, 5),
            'source_id' => random_int(1, 3),
        ];
    }
}
