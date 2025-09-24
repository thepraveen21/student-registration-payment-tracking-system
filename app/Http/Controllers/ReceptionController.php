<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReceptionController extends Controller
{
    public function dashboard()
    {
        $totalStudents = Student::count();
        $totalPayments = Payment::sum('amount');

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

        return view('reception.dashboard', compact(
            'totalStudents',
            'totalPayments',
            'monthlyPayments',
            'recentPayments'
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