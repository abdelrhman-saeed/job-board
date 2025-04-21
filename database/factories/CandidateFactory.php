<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->word,
            'email'     => $this->faker->safeEmail,
            'phone'     => $this->faker->phoneNumber,
            'password'  => 'password',
            'birth'     => $this->faker->date(),
            'city'      => $this->faker->city,
            'country'   => substr($this->faker->country, 0, 2),
            'gender'    => $this->faker->randomElement(['male', 'female']),
        ];
    }
}
