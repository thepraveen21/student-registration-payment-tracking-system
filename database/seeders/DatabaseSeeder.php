<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Student;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a few courses
        $courses = Course::factory()->count(3)->create();

        // Create 10 students, each assigned to a random course
        $students = Student::factory()->count(10)->create([
            'course_id' => $courses->random()->id,
        ]);

        // Give each student 1–3 payments
        foreach ($students as $student) {
            Payment::factory()->count(rand(1, 3))->create([
                'student_id' => $student->id,
            ]);
        }
    }
}
