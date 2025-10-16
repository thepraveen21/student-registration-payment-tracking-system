<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Payment;
use App\Models\PaymentSchedule;
use App\Models\Course;
use App\Models\Notification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdvancedReportController extends Controller
{
    /**
     * Display the reports dashboard.
     */
    public function index()
    {
        // Quick statistics for the dashboard
        $stats = [
            'total_students' => Student::count(),
            'total_payments' => Payment::sum('amount'),
            'pending_payments' => PaymentSchedule::where('status', 'pending')->sum('amount_due'),
            'overdue_payments' => PaymentSchedule::where('status', 'overdue')->sum('amount_due'),
            'total_courses' => Course::count(),
        ];

        return view('admin.reports.index', compact('stats'));
    }

    /**
     * Generate course-wise student report.
     */
    public function courseWiseStudents(Request $request)
    {
        $courses = Course::withCount('students')->get();
        
        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = PDF::loadView('admin.reports.pdf.course-wise-students', compact('courses'));
            return $pdf->download('course-wise-students-' . date('Y-m-d') . '.pdf');
        }

        return view('admin.reports.course-wise-students', compact('courses'));
    }

    /**
     * Generate payment status report.
     */
    public function paymentStatus(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'course_id' => 'nullable|exists:courses,id',
            'status' => 'nullable|in:all,paid,pending,overdue',
        ]);

        $query = Student::with(['course', 'payments', 'paymentSchedules']);

        // Apply filters
        if ($request->start_date) {
            $query->whereHas('paymentSchedules', function ($q) use ($request) {
                $q->where('due_date', '>=', $request->start_date);
            });
        }

        if ($request->end_date) {
            $query->whereHas('paymentSchedules', function ($q) use ($request) {
                $q->where('due_date', '<=', $request->end_date);
            });
        }

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        $students = $query->get()->map(function ($student) {
            $totalDue = $student->paymentSchedules->sum('amount_due');
            $totalPaid = $student->payments->sum('amount');
            $pendingAmount = $student->paymentSchedules->where('status', 'pending')->sum('amount_due');
            $overdueAmount = $student->paymentSchedules->where('status', 'overdue')->sum('amount_due');

            return [
                'student' => $student,
                'total_due' => $totalDue,
                'total_paid' => $totalPaid,
                'pending_amount' => $pendingAmount,
                'overdue_amount' => $overdueAmount,
                'balance' => $totalDue - $totalPaid,
            ];
        });

        // Filter by payment status if specified
        if ($request->status && $request->status != 'all') {
            $students = $students->filter(function ($item) use ($request) {
                switch ($request->status) {
                    case 'paid':
                        return $item['balance'] <= 0;
                    case 'pending':
                        return $item['pending_amount'] > 0;
                    case 'overdue':
                        return $item['overdue_amount'] > 0;
                    default:
                        return true;
                }
            });
        }

        $courses = Course::all();

        if ($request->has('export') && $request->export == 'pdf') {
            $filters = $request->only(['start_date', 'end_date', 'course_id', 'status']);
            $pdf = PDF::loadView('admin.reports.pdf.payment-status', compact('students', 'filters'));
            return $pdf->download('payment-status-report-' . date('Y-m-d') . '.pdf');
        }

        return view('admin.reports.payment-status', compact('students', 'courses'));
    }

    /**
     * Generate overdue cases report.
     */
    public function overdueCases(Request $request)
    {
        $request->validate([
            'days_overdue' => 'nullable|integer|min:1',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $query = PaymentSchedule::where('status', 'overdue')
                               ->where('due_date', '<', Carbon::today())
                               ->with(['student.course']);

        // Filter by minimum days overdue
        if ($request->days_overdue) {
            $cutoffDate = Carbon::today()->subDays($request->days_overdue);
            $query->where('due_date', '<=', $cutoffDate);
        }

        // Filter by course
        if ($request->course_id) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        $overdueSchedules = $query->get()->map(function ($schedule) {
            $daysOverdue = Carbon::today()->diffInDays($schedule->due_date);
            $schedule->days_overdue = $daysOverdue;
            return $schedule;
        })->sortByDesc('days_overdue');

        $courses = Course::all();

        if ($request->has('export') && $request->export == 'pdf') {
            $filters = $request->only(['days_overdue', 'course_id']);
            $pdf = PDF::loadView('admin.reports.pdf.overdue-cases', compact('overdueSchedules', 'filters'));
            return $pdf->download('overdue-cases-report-' . date('Y-m-d') . '.pdf');
        }

        return view('admin.reports.overdue-cases', compact('overdueSchedules', 'courses'));
    }

    /**
     * Generate revenue report.
     */
    public function revenue(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'grouping' => 'nullable|in:daily,weekly,monthly,yearly',
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subMonths(6);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();
        $grouping = $request->grouping ?? 'monthly';

        // Get payments within date range
        $paymentsQuery = Payment::whereBetween('payment_date', [$startDate, $endDate])
                              ->with(['student.course']);

        $payments = $paymentsQuery->get();

        // Group payments by date
        switch ($grouping) {
            case 'daily':
                $groupedPayments = $payments->groupBy(function ($payment) {
                    return $payment->payment_date->format('Y-m-d');
                });
                break;
            case 'weekly':
                $groupedPayments = $payments->groupBy(function ($payment) {
                    return $payment->payment_date->format('Y-W');
                });
                break;
            case 'monthly':
                $groupedPayments = $payments->groupBy(function ($payment) {
                    return $payment->payment_date->format('Y-m');
                });
                break;
            case 'yearly':
                $groupedPayments = $payments->groupBy(function ($payment) {
                    return $payment->payment_date->format('Y');
                });
                break;
        }

        // Calculate totals
        $revenueData = $groupedPayments->map(function ($periodPayments) {
            return [
                'total_amount' => $periodPayments->sum('amount'),
                'total_count' => $periodPayments->count(),
                'payment_methods' => $periodPayments->groupBy('payment_method')->map->count(),
                'courses' => $periodPayments->groupBy('student.course.name')->map->count(),
            ];
        });

        $totalRevenue = $payments->sum('amount');
        $totalTransactions = $payments->count();

        if ($request->has('export') && $request->export == 'pdf') {
            $filters = ['start_date' => $startDate, 'end_date' => $endDate, 'grouping' => $grouping];
            $pdf = PDF::loadView('admin.reports.pdf.revenue', compact('revenueData', 'totalRevenue', 'totalTransactions', 'filters'));
            return $pdf->download('revenue-report-' . date('Y-m-d') . '.pdf');
        }

        return view('admin.reports.revenue', compact('revenueData', 'totalRevenue', 'totalTransactions', 'startDate', 'endDate', 'grouping'));
    }

    /**
     * Generate student enrollment summary.
     */
    public function enrollmentSummary(Request $request)
    {
        $query = Student::with('course');

        // Filter by date range
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $students = $query->get();
        
        $summary = [
            'total_students' => $students->count(),
            'by_course' => $students->groupBy('course.name')->map->count(),
            'by_month' => $students->groupBy(function ($student) {
                return $student->created_at->format('Y-m');
            })->map->count(),
            'recent_enrollments' => $students->sortByDesc('created_at')->take(10),
        ];

        if ($request->has('export') && $request->export == 'pdf') {
            $filters = $request->only(['start_date', 'end_date']);
            $pdf = PDF::loadView('admin.reports.pdf.enrollment-summary', compact('summary', 'filters'));
            return $pdf->download('enrollment-summary-' . date('Y-m-d') . '.pdf');
        }

        return view('admin.reports.enrollment-summary', compact('summary'));
    }

    /**
     * Generate notifications report.
     */
    public function notifications(Request $request)
    {
        $query = Notification::with('student');

        // Filter by date range
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('sent_at', [$request->start_date, $request->end_date]);
        }

        // Filter by type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $notifications = $query->latest('sent_at')->paginate(20);
        
        $stats = [
            'total_sent' => $query->where('status', 'sent')->count(),
            'total_pending' => $query->where('status', 'pending')->count(),
            'total_failed' => $query->where('status', 'failed')->count(),
            'by_type' => $query->groupBy('type')->selectRaw('type, count(*) as count')->pluck('count', 'type'),
        ];

        return view('admin.reports.notifications', compact('notifications', 'stats'));
    }
}
