<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word . ' Course',
            'description' => $this->faker->sentence,
            'duration' => $this->faker->numberBetween(3, 12) . ' months',
        ];
    }
}
