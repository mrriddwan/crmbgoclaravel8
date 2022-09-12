<?php

namespace Database\Factories;

use App\Models\ToDo;
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
        return [
            'todo_created' => $this->faker ->dateTimeThisYear('+2 month'),
            'todo_deadline' => $this->faker ->dateTimeThisYear('+5 month'),
            'todo_remark' => $this->faker ->realText($maxNbChars = 50),
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
