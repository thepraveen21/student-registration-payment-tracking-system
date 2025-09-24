<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'amount' => $this->faker->numberBetween(100, 1000),
            'payment_date' => $this->faker->date(),
            'recorded_by' => User::factory(),   // ✅ FIX: make sure this column is filled
        ];
    }
}
