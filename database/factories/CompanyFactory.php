<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    // protected $model = Company::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'uuid'          => $this->faker->uuid(),
            'name'          => $this->faker->name,
            'email'         => $this->faker->safeEmail,
            'password'      => 'password',
            'phone'         => $this->faker->phoneNumber,
            'website'       => $this->faker->url,
            'description'   => $this->faker->sentence,
            'address'       => $this->faker->address,
            'city'          => $this->faker->city,
            'country'       => substr($this->faker->country, 0, 2),
        ];
    }
}
