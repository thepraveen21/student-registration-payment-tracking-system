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

        $paymentChartData = Payment::select(
            DB::raw('sum(amount) as total'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
        ->groupBy('month')
        ->get()
        ->pluck('total', 'month');

        $courseChartData = Student::with('course')
            ->get()
            ->groupBy('course.name')
            ->map(function ($students) {
                return $students->count();
            });

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
