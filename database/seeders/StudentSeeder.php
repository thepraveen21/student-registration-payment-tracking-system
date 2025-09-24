<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Course;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::factory()->count(10)->create();

        // Or if inserting manually, make sure columns match migration
        /*
        Student::create([
            'course_id' => Course::inRandomOrder()->first()->id,
            'registration_number' => 'STU-' . now()->year . '-' . rand(1000, 9999),
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'student_phone' => '1234567890',     // ✅ CORRECT
            'parent_phone' => '0987654321',      // ✅ CORRECT
            'date_of_birth' => '2000-01-01',     // ✅ CORRECT
            'address' => '123 Example Street',
            'qr_code_path' => null,
        ]);
        */
    }
}
