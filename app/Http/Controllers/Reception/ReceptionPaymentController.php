<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceptionPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('student')->latest()->get();
        return view('reception.payments.index', compact('payments'));
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
            'amount' => 'required|numeric|gt:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,bank_transfer',
            'receipt_number' => 'nullable|string|max:100|unique:payments,receipt_number',
            'notes' => 'nullable|string|max:200',
        ]);

        $data = $request->all();
        
        // Generate receipt number if not provided
        if (empty($data['receipt_number'])) {
            $data['receipt_number'] = Payment::generateReceiptNumber();
        }
        
        $data['recorded_by'] = Auth::id();

        Payment::create($data);

        return redirect()->route('reception.payments.index')
                         ->with('success', 'Payment added successfully.');
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
        
        // Generate receipt number if not provided and currently empty
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
}
