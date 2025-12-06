<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\MonthlyPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Optional filter: course
        $courseId = $request->get('course_id');

        // Load students with related course + center
        $students = Student::with(['course', 'center'])
            ->when($courseId, fn($q) => $q->where('course_id', $courseId))
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        if ($students->isEmpty()) {
            return view('reception.reports.index', [
                'students' => $students,
                'attendanceMatrix' => [],
                'weekRanges' => [],
                'stats' => [],
                'paymentReports' => [],
                'courses' => \App\Models\Course::all(),
            ]);
        }

        // Determine earliest start and latest end
        $minStart = null;
        $maxEnd = null;
        $studentStarts = [];

        foreach ($students as $student) {
            $start = Carbon::parse($student->created_at)->startOfDay();
            $end = $start->copy()->addWeeks(16)->endOfDay();

            $studentStarts[$student->id] = $start;

            $minStart = $minStart ? ($start->lt($minStart) ? $start->copy() : $minStart) : $start->copy();
            $maxEnd = $maxEnd ? ($end->gt($maxEnd) ? $end->copy() : $maxEnd) : $end->copy();
        }

        // Fetch attendances
        $attendances = Attendance::whereIn('student_id', $students->pluck('id'))
            ->whereBetween('attended_at', [$minStart, $maxEnd])
            ->orderBy('attended_at')
            ->get()
            ->groupBy('student_id');

        // Build week ranges
        $firstStudentStart = reset($studentStarts) ?? Carbon::now()->startOfDay();
        $weekRanges = [];
        $weekStart = $firstStudentStart->copy();
        for ($i = 1; $i <= 16; $i++) {
            $weekEnd = $weekStart->copy()->endOfWeek();
            $weekRanges[] = [
                'label' => "W{$i}",
                'start' => $weekStart->format('Y-m-d'),
                'end' => $weekEnd->format('Y-m-d'),
            ];
            $weekStart->addWeek();
        }

        // Build attendance matrix per student
        $attendanceMatrix = [];
        $stats = [];

        foreach ($students as $student) {
            $start = $studentStarts[$student->id]->copy();
            $weekStart = $start->copy();
            $studentAttendance = $attendances->get($student->id, collect());
            $row = [];
            $presentWeeks = 0;

            for ($w = 0; $w < 16; $w++) {
                $weekEnd = $weekStart->copy()->endOfWeek();

                $count = $studentAttendance->filter(function ($a) use ($weekStart, $weekEnd) {
                    $att = Carbon::parse($a->attended_at);
                    return $att->between($weekStart, $weekEnd);
                })->count();

                $attended = $count > 0;
                if ($attended) $presentWeeks++;

                $row[$w] = [
                    'attended' => $attended,
                    'count' => $count,
                    'start' => $weekStart->copy(),
                    'end' => $weekEnd->copy(),
                ];

                $weekStart->addWeek();
            }

            $attendanceMatrix[$student->id] = $row;

            $totalWeeks = 16;
            $percent = $totalWeeks ? round(($presentWeeks / $totalWeeks) * 100, 2) : 0;

            $stats[$student->id] = [
                'present_weeks' => $presentWeeks,
                'absent_weeks' => $totalWeeks - $presentWeeks,
                'percent' => $percent,
            ];
        }

        // --------------------------------------------------
        // PAYMENT REPORTS (Monthly Payments by month)
        // --------------------------------------------------
        $paymentReports = DB::table('monthly_payments')
            ->join('students', 'students.id', '=', 'monthly_payments.student_id')
            ->leftJoin('centers', 'centers.id', '=', 'students.center_id')
            ->select(
                'students.id as student_id',
                'students.first_name',
                'students.last_name',
                'centers.name as center_name',
                'monthly_payments.amount',
                DB::raw("DATE_FORMAT(monthly_payments.payment_date, '%Y-%m') as month")
            )
            ->when($courseId, fn($q) => $q->where('monthly_payments.course_id', $courseId))
            ->orderBy('monthly_payments.payment_date', 'asc')
            ->get()
            ->groupBy('month'); // Group all payments by month

        // Load course list for dropdown filter
        $courses = \App\Models\Course::all();

        return view('reception.reports.index', compact(
            'students',
            'attendanceMatrix',
            'weekRanges',
            'stats',
            'courses',
            'paymentReports'
        ));
    }
}
