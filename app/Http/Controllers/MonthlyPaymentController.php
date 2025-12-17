<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlyPayment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Facades\Log;

class MonthlyPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = MonthlyPayment::with('student', 'course')->orderBy('payment_date', 'desc')->paginate(10);
        $totalAmount = MonthlyPayment::sum('amount');
        $todayAmount = MonthlyPayment::whereDate('payment_date', today())->sum('amount');
        $thisMonthAmount = MonthlyPayment::whereBetween('payment_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
        return view('admin.payments.index', compact('payments', 'totalAmount', 'todayAmount', 'thisMonthAmount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('admin.payments.create', compact('students', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'month_number' => 'required|integer|min:1|max:12',
            'amount' => 'required|numeric|gt:0',
            'payment_date' => 'required|date_format:Y-m-d\TH:i',
            'notes' => 'nullable|string|max:200',
        ]);

        $data = $request->all();
        $data['recorded_by'] = auth()->id();

        MonthlyPayment::create($data);

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Monthly payment recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = MonthlyPayment::with('student', 'course', 'recordedBy')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = MonthlyPayment::findOrFail($id);
        $students = Student::all();
        $courses = Course::all();
        return view('admin.payments.edit', compact('payment', 'students', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'month_number' => 'required|integer|min:1|max:12',
            'amount' => 'required|numeric|gt:0',
            'payment_date' => 'required|date_format:Y-m-d\TH:i',
            'notes' => 'nullable|string|max:200',
        ]);

        $payment = MonthlyPayment::findOrFail($id);
        $payment->update($request->all());

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Monthly payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = MonthlyPayment::findOrFail($id);
        $payment->delete();

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Monthly payment deleted successfully.');
    }

    public function getCourse(string $id)
    {
        Log::info('Fetching course for student ID: ' . $id);
        $student = Student::with('course')->findOrFail($id);
        Log::info('Returned course: ' . json_encode($student->course));
        return response()->json($student->course);
    }
}
