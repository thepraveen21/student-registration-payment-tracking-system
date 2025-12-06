<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\QRCode;
use Carbon\Carbon;
use App\Models\Course;


class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['student.course', 'student.payments'])
            ->orderBy('attended_at', 'desc');

        // Filters
        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->course) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('course_id', $request->course);
            });
        }

        if ($request->date) {
            $query->whereDate('attended_at', $request->date);
        }

        // Paginate results
        $attendances = $query->paginate(15);

        // Group AFTER pagination
        $groupedAttendances = $attendances->getCollection()
            ->map(function ($attendance) {
                $courseFee = $attendance->student->course->fee ?? 0;
                $totalPaid = $attendance->student->payments->sum('amount');
                $attendance->payment_status = $totalPaid >= $courseFee && $courseFee > 0 ? 'Paid' : 'Pending';
                return $attendance;
            })
            ->groupBy(function ($attendance) {
                return $attendance->attended_at->format('Y-m-d');
            });

        // Replace collection with grouped version
        $attendances->setCollection(collect($groupedAttendances));

        // Other data
        $courses = Course::all();
        $latestAttendance = Attendance::orderBy('attended_at', 'desc')->first();

        return view('reception.attendance.index', compact(
            'attendances',
            'courses',
            'latestAttendance'
        ));
    }


    public function scan()
    {
        return view('reception.attendance.scan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $urlParts = explode('/', $request->qr_code);
        $code = end($urlParts);

        $qrCode = QRCode::where('code', $code)->first();

        if (!$qrCode || !$qrCode->student) {
            return response()->json([
                'message' => 'Invalid or unassigned QR code.',
                'status' => 'error'
            ], 404);
        }

        $student = $qrCode->student;

        $today = Carbon::today();
        $existingAttendance = Attendance::where('student_id', $student->id)
            ->whereDate('attended_at', $today)
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'message' => "Attendance already marked for {$student->name} today.",
                'status' => 'error',
                'student_name' => $student->name,
                'registration_number' => $student->registration_number,
                'course' => $student->course->name ?? 'N/A',
                'time' => now()->format('h:i A')
            ], 409);
        }

        Attendance::create([
            'student_id' => $student->id,
            'attended_at' => now(),
            'status' => 'present',
            'notes' => 'Scanned via reception QR scanner.',
        ]);

        return response()->json([
            'message' => "Attendance marked for {$student->name}.",
            'status' => 'success',
            'student_name' => $student->name,
            'registration_number' => $student->registration_number,
            'course' => $student->course->name ?? 'N/A',
            'time' => now()->format('h:i A')
        ]);
    }

}
