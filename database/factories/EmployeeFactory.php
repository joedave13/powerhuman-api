<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = ['Male', 'Female', 'Other'];

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'gender' => $this->faker->randomElement($gender),
            'age' => $this->faker->numberBetween(25, 50),
            'photo' => $this->faker->imageUrl(),
            'phone' => $this->faker->phoneNumber(),
            'role_id' => $this->faker->numberBetween(1, 5),
            'team_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
