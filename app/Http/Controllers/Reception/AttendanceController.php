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
        $query = Attendance::with(['student.course', 'student.monthlyPayments'])
            ->orderBy('attended_at', 'desc');

        // Filters
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('registration_number', 'like', '%' . $search . '%');
            });
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
                $monthly_payments = $attendance->student->monthlyPayments->keyBy('month_number');
                $payment_status_by_month = [];
                for ($i = 1; $i <= 4; $i++) {
                    $payment_status_by_month[$i] = $monthly_payments->has($i) ? 'Paid' : 'Unpaid';
                }
                $attendance->payment_status_by_month = $payment_status_by_month;
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

        return view('reception.attendance.index', [
            'attendances' => $attendances,
            'courses' => $courses,
            'latestAttendance' => $latestAttendance,
            'search' => $request->search ?? '',
            'selected_course' => $request->course ?? '',
            'selected_date' => $request->date ?? '',
        ]);
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
