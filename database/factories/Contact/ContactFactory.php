<?php

namespace Database\Factories\Contact;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact\Contact;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContactFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker -> unique()->company(),
            'address' => $this->faker -> unique()->address(),
            'remark' => $this->faker -> realText($maxNbChars=50),
            'user_id' => random_int(1,10),
            'status_id' => random_int(1,5),
            'type_id' => random_int(1,5),
            'category_id' => random_int(1,5),
            'industry_id' => random_int(1,5),
        ];
    }
}
