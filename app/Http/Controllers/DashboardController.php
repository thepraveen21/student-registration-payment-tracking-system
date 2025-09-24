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

        $recentActivities = AuditLog::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalStudents',
            'activeStudents',
            'overduePayments',
            'monthlyRevenue',
            'paymentChartData',
            'courseChartData',
            'recentActivities'
        ));
    }

    // Reception Dashboard
    public function indexReception()
    {
        return view('Reception'); // resources/views/Reception.blade.php
    }
}
