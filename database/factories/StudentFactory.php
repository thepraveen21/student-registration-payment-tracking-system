<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'registration_number' => 'STU-' . now()->year . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'student_phone' => $this->faker->phoneNumber(),   // ✅ matches migration
            'parent_phone' => $this->faker->phoneNumber(),    // ✅ matches migration
            'date_of_birth' => $this->faker->date(),          // ✅ matches migration
            'address' => $this->faker->address(),
            'qr_code_path' => null,
        ];
    }
}
