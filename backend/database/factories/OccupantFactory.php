<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Occupant>
 */
class OccupantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'ktp' => null,
            'status' => $this->faker->randomElement(['permanent', 'contract']),
            'phone' => $this->faker->phoneNumber(),
            'is_married' => $this->faker->boolean(),
        ];
    }
}
