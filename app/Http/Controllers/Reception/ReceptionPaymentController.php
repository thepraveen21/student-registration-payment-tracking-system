<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use App\Models\MonthlyPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Center;

class ReceptionPaymentController extends Controller
{
    public function index(Request $request)
    {
        // Load filters
        $courses = Course::all();
        $centers = Center::all();

        // Base query with relations
        $query = MonthlyPayment::with(['student', 'course', 'recordedBy']);

        // --------------------------
        // Course Filter
        // --------------------------
        if ($request->course) {
            $query->where('course_id', $request->course);
        }

        // --------------------------
        // Center Filter
        // --------------------------
        if ($request->center) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('center_id', $request->center);
            });
        }

        // --------------------------
        // Search Filter (FIXED)
        // --------------------------
        $search = $request->search;  // ⭐ FIXED: define $search

        if (!empty($search)) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%");
            });
        }

        // --------------------------
        // Fetch Results
        // --------------------------
        $monthlyPayments = $query->orderBy('payment_date', 'desc')->get();

        return view('reception.payments.index', compact(
            'monthlyPayments',
            'courses',
            'centers'
        ));
    }


    public function create()
    {
        $students = Student::all();
        return view('reception.payments.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'month_number' => 'required|integer|min:1|max:4',
            'amount' => 'required|numeric|gt:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,bank_transfer',
            'notes' => 'nullable|string|max:200',
        ]);

        $data = $request->only([
            'student_id',
            'course_id',
            'month_number',
            'payment_date',
            'amount',
            'notes'
        ]);

        $data['recorded_by'] = Auth::id();

        // Save into NEW table
        MonthlyPayment::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Monthly payment added successfully.'
        ]);
    }

    public function show(Payment $payment)
    {
        return view('reception.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $students = Student::all();
        return view('reception.payments.edit', compact('payment', 'students'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|gt:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,bank_transfer',
            'receipt_number' => 'nullable|string|max:100|unique:payments,receipt_number,' . $payment->id,
            'notes' => 'nullable|string|max:200',
        ]);

        $data = $request->all();

        if (empty($data['receipt_number']) && empty($payment->receipt_number)) {
            $data['receipt_number'] = Payment::generateReceiptNumber();
        }

        $payment->update($data);

        return redirect()->route('reception.payments.index')
                         ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('reception.payments.index')
                         ->with('success', 'Payment deleted successfully.');
    }

    public function monthlyPayments(Student $student)
    {
        $student->load('monthlyPayments');
        return view('reception.payments.monthly', compact('student'));
    }

    public function storeMonthlyPayments(Request $request, Student $student)
    {
        $request->validate([
            'monthly_payments' => 'required|array',
            'monthly_payments.*.payment_date' => 'nullable|date',
            'monthly_payments.*.amount' => 'nullable|numeric',
            'monthly_payments.*.notes' => 'nullable|string',
        ]);

        foreach ($request->monthly_payments as $monthNumber => $paymentData) {
            if (!empty($paymentData['payment_date']) && !empty($paymentData['amount'])) {
                MonthlyPayment::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'course_id' => $student->course_id,
                        'month_number' => $monthNumber,
                    ],
                    [
                        'payment_date' => $paymentData['payment_date'],
                        'amount' => $paymentData['amount'],
                        'recorded_by' => Auth::id(),
                        'notes' => $paymentData['notes'],
                    ]
                );
            }
        }

        return redirect()->route('reception.students.monthly-payments', $student)
                         ->with('success', 'Monthly payments updated successfully.');
    }

    public function getStudent(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $qr = trim($request->code);
        $qr = strtoupper($qr);

        // Extract filename (if scanner includes .svg or full path)
        $justFilename = strtoupper(basename($qr)); // Example: QR00022 or QR00022.SVG

        // Fix: match against BOTH columns correctly
        $student = Student::with(['course', 'center'])
            ->whereRaw('UPPER(TRIM(qr_code)) = ?', [$justFilename])
            ->orWhereRaw('UPPER(TRIM(REPLACE(qr_code_path, "qrcodes/", ""))) = ?', [$justFilename])
            ->orWhereRaw('UPPER(TRIM(qr_code_path)) LIKE ?', ["%{$justFilename}%"])
            ->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'No student assigned to this QR code.'
            ]);
        }

        return response()->json([
            'success' => true,
            'student' => [
                'id' => $student->id,
                'full_name' => $student->first_name . ' ' . $student->last_name,
                'registration_number' => $student->registration_number,
                'course' => [
                    'id' => $student->course->id ?? null,
                    'name' => $student->course->name ?? null
                ],
                'center' => [
                    'id' => $student->center->id ?? null,
                    'name' => $student->center->name ?? null
                ],
                'status' => $student->status,
            ]
        ]);
    }


    public function paymentPopup(Student $student)
    {
        return view('reception.payments.popup', compact('student'));
    }
}
