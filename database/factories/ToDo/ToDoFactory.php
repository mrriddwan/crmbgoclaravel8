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
        $todo_created = $this->faker->dateTimeThisYear('+1 week');
        $todo_deadline = $this->faker->dateTimeBetween($todo_created->format('Y-m-d'),$todo_created->format('Y-m-d') . '+5 months');

        // $end_date = $this->faker->dateTimeBetween(
        //     $start_date->format('Y-m-d H:i:s') . ' +3 days',
        //     $start_date->format('Y-m-d H:i:s') . ' +3 days'
        // );

        return [
            'todo_created' => $todo_created,
            'todo_deadline' => $todo_deadline,
            'todo_remark' => $this->faker->realText($maxNbChars = 50),
            'contact_id' => random_int(1, 10),
            'user_id' => random_int(2, 10),
            'task_id' => random_int(1, 5),
            'status_id' => random_int(1, 5),
            'type_id' => random_int(1, 5),
            'priority_id' => random_int(1, 2),
            'color_id' => random_int(1, 5),
            'source_id' => random_int(1, 3),
        ];
    }
}
