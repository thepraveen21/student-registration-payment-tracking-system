<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\PaymentSchedule;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use App\Models\Schedule;
use App\Models\Task;

class ReceptionController extends Controller
{
    public function dashboard()
    {
        // Basic stats (your existing queries)
        $totalStudents = Student::count();
        $totalPayments = Payment::sum('amount');

        $todaysRegistrations = Student::whereDate('created_at', Carbon::today())->count();

        $pendingPayments = PaymentSchedule::where('status', 'pending')
            ->orWhere('status', 'overdue')
            ->count();

        $overduePayments = PaymentSchedule::where('status', 'overdue')->count();

        $todaysRevenue = Payment::whereDate('payment_date', Carbon::today())->sum('amount');
        $yesterdaysRevenue = Payment::whereDate('payment_date', Carbon::yesterday())->sum('amount');

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

        $recentActivities = AuditLog::with('user')->latest()->take(4)->get();

        $overduePaymentSchedules = PaymentSchedule::with('student')->where('status', 'overdue')->count();

        $studentsNeedingVerification = Student::whereDoesntHave('payments')
            ->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])
            ->count();

        // --- SAFE: todaySchedules & pendingTasks (won't crash if tables/models not present) ---
        $todaySchedules = collect();
        if (Schema::hasTable('schedules')) {
            if (class_exists(Schedule::class)) {
                $todaySchedules = Schedule::whereDate('date', now()->toDateString())->get();
            } else {
                $todaySchedules = DB::table('schedules')->whereDate('date', now()->toDateString())->get();
            }
        }

        $pendingTasks = collect();
        if (Schema::hasTable('tasks')) {
            if (class_exists(Task::class)) {
                $pendingTasks = Task::where('status', 'pending')->get();
            } else {
                $pendingTasks = DB::table('tasks')->where('status', 'pending')->get();
            }
        }

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
            'studentsNeedingVerification',
            'todaySchedules',
            'pendingTasks'
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

        $payments = $query->orderBy('id', 'asc')->paginate(10);

        return view('reception.reports.index', compact('payments'));
    }

    public function settings()
    {
        return view('reception.settings');
    }

    /**
     * Schedule page (list all schedules)
     */
    public function schedule()
    {
        // All schedules (not just today) for the schedule page
        $schedules = collect();
        if (Schema::hasTable('schedules')) {
            if (class_exists(Schedule::class)) {
                $schedules = Schedule::orderBy('date')->get();
            } else {
                $schedules = DB::table('schedules')->orderBy('date')->get();
            }
        }

        // pending tasks for schedule page
        $pendingTasks = collect();
        if (Schema::hasTable('tasks')) {
            if (class_exists(Task::class)) {
                $pendingTasks = Task::where('status', 'pending')->get();
            } else {
                $pendingTasks = DB::table('tasks')->where('status', 'pending')->get();
            }
        }

        return view('reception.schedule.index', compact('schedules', 'pendingTasks'));
    }
}
