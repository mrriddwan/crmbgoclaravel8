<?php

namespace Database\Factories\Contact;

use App\Models\Contact\ContactIncharge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactIncharge>
 */
class ContactInchargeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactIncharge::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'contact_id' => random_int(1,100),
            'name' => $this->faker ->name(),
            'email' => $this->faker ->email(),
            'phone_mobile' => $this->faker -> phoneNumber(),
            'phone_office' => $this->faker -> phoneNumber(),
        ];
    }
}
