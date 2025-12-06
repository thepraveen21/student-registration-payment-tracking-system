<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\QRCode;
use Illuminate\Support\Facades\DB;

class StudentObserver
{
    /**
     * Handle the Student "created" event.
     */
    public function created(Student $student)
    {
        DB::transaction(function () use ($student) {
            $qr = QRCode::whereNull('student_id')
                ->where('is_assigned', false)
                ->lockForUpdate()
                ->first();

            if (! $qr) {
                return; // No available QR codes
            }

            $qr->student_id = $student->id;
            $qr->is_assigned = true;
            $qr->save();

            // Optionally update student's qr_code_path
            $student->qr_code_path = $qr->qr_image_path;
            $student->save();
        });
    }
}
