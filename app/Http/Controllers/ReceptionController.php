<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\PaymentSchedule;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReceptionController extends Controller
{
    public function dashboard()
    {
        $totalStudents = Student::count();
        $totalPayments = Payment::sum('amount');

        // Today's registrations
        $todaysRegistrations = Student::whereDate('created_at', Carbon::today())->count();

        // Pending payments (overdue and due today)
        $pendingPayments = PaymentSchedule::where('status', 'pending')
            ->orWhere('status', 'overdue')
            ->count();

        // Overdue payments
        $overduePayments = PaymentSchedule::where('status', 'overdue')->count();

        // Today's revenue
        $todaysRevenue = Payment::whereDate('payment_date', Carbon::today())->sum('amount');

        // Yesterday's revenue for comparison
        $yesterdaysRevenue = Payment::whereDate('payment_date', Carbon::yesterday())->sum('amount');

        // Students registered this week
        $weeklyNewStudents = Student::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        $paymentsByMonth = Payment::select(
            DB::raw('sum(amount) as total'),
            DB::raw('MONTH(payment_date) as month')
        )
        ->whereYear('payment_date', Carbon::now()->year)
        ->groupBy('month')
        ->pluck('total', 'month');

        $monthlyPayments = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyPayments[$i] = $paymentsByMonth->get($i, 0);
        }

        $recentPayments = Payment::with('student')->latest()->take(5)->get();

        // Recent activities from audit logs
        $recentActivities = AuditLog::with('user')
            ->latest()
            ->take(4)
            ->get();

        // Overdue payment schedules for pending tasks
        $overduePaymentSchedules = PaymentSchedule::with('student')
            ->where('status', 'overdue')
            ->count();

        // Students that need record verification (created in last week but no payments)
        $studentsNeedingVerification = Student::whereDoesntHave('payments')
            ->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])
            ->count();

        return view('reception.dashboard', compact(
            'totalStudents',
            'totalPayments',
            'todaysRegistrations',
            'pendingPayments',
            'overduePayments',
            'todaysRevenue',
            'yesterdaysRevenue',
            'weeklyNewStudents',
            'monthlyPayments',
            'recentPayments',
            'recentActivities',
            'overduePaymentSchedules',
            'studentsNeedingVerification'
        ));
    }

    public function reports(Request $request)
    {
        $query = Payment::with('student');

        if ($request->has('start_date') && $request->get('start_date')) {
            $query->whereDate('payment_date', '>=', $request->get('start_date'));
        }

        if ($request->has('end_date') && $request->get('end_date')) {
            $query->whereDate('payment_date', '<=', $request->get('end_date'));
        }

        $payments = $query->latest()->get();

        return view('reception.reports.index', compact('payments'));
    }

    public function settings()
    {
        return view('reception.settings');
    }
}