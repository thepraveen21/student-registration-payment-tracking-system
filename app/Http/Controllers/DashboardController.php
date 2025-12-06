<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Course;
use App\Models\Payment;
use App\Models\PaymentSchedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Admin Dashboard
    public function index()
    {
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $overduePayments = PaymentSchedule::where('status', 'overdue')->count();
        $monthlyRevenue = Payment::whereMonth('created_at', now()->month)->sum('amount');

        // Payment chart: last 6 months (ensures chronological labels and zero-fill)
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('M Y'));
        }

        $paymentSums = Payment::select(
            DB::raw('YEAR(created_at) as yr'),
            DB::raw('MONTH(created_at) as mth'),
            // Use MIN(created_at) inside DATE_FORMAT so month_label is an aggregate
            DB::raw("DATE_FORMAT(MIN(created_at), '%b %Y') as month_label"),
            DB::raw('SUM(amount) as total')
        )
        ->whereBetween('created_at', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
        ->groupBy('yr', 'mth')
        ->orderBy('yr', 'asc')
        ->orderBy('mth', 'asc')
        ->get()
        ->mapWithKeys(function ($row) {
            return [$row->month_label => (float) $row->total];
        });

        // Ensure every month appears (fill missing months with 0)
        $paymentChartData = $months->mapWithKeys(function ($m) use ($paymentSums) {
            return [$m => $paymentSums->get($m) ?? 0];
        });

        // Course distribution: include all courses (zero where no students)
        $courseChartData = Course::leftJoin('students', 'courses.id', '=', 'students.course_id')
            ->select('courses.name', DB::raw('COUNT(students.id) as students_count'))
            ->groupBy('courses.id', 'courses.name')
            ->orderBy('courses.name')
            ->get()
            ->pluck('students_count', 'name');

        $recentStudents = Student::with('course')->latest()->take(5)->get();
        $recentPayments = Payment::with('student')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalStudents',
            'activeStudents',
            'overduePayments',
            'monthlyRevenue',
            'paymentChartData',
            'courseChartData',
            'recentStudents',
            'recentPayments'
        ));
    }

    // Reception Dashboard
    public function indexReception()
    {
        $totalStudents = Student::count();
        $todaysRegistrations = Student::whereDate('created_at', now()->today())->count();
        $pendingPayments = PaymentSchedule::where('status', 'pending')
            ->orWhere('status', 'overdue')
            ->count();
        $overduePayments = PaymentSchedule::where('status', 'overdue')->count();
        $todaysRevenue = Payment::whereDate('payment_date', now()->today())->sum('amount');
        $yesterdaysRevenue = Payment::whereDate('payment_date', now()->yesterday())->sum('amount');
        $weeklyNewStudents = Student::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();

        $recentPayments = Payment::with('student')->latest()->take(5)->get();
        $recentActivities = AuditLog::with('user')->latest()->take(4)->get();
        $overduePaymentSchedules = PaymentSchedule::with('student')
            ->where('status', 'overdue')
            ->count();
        $studentsNeedingVerification = Student::whereDoesntHave('payments')
            ->whereBetween('created_at', [now()->subWeek(), now()])
            ->count();

        return view('Reception', compact(
            'totalStudents',
            'todaysRegistrations',
            'pendingPayments',
            'overduePayments',
            'todaysRevenue',
            'yesterdaysRevenue',
            'weeklyNewStudents',
            'recentPayments',
            'recentActivities',
            'overduePaymentSchedules',
            'studentsNeedingVerification'
        ));
    }
}
