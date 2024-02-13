<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Devis>
 */
class DevisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'e_mail' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'postal' => $this->faker->postcode,
            'interest' => $this->faker->word,
            'message' => $this->faker->paragraph,
            'product_id' => $this->faker->randomDigitNotNull,
        ];
    }
}
