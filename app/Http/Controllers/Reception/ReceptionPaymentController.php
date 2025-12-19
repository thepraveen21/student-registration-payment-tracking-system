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
use Zxing\QrReader;
use Carbon\Carbon;

class ReceptionPaymentController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::all();
        $centers = Center::all();

        $query = MonthlyPayment::with(['student', 'course', 'recordedBy']);

        if ($request->course) {
            $query->where('course_id', $request->course);
        }

        if ($request->center) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('center_id', $request->center);
            });
        }

        if ($request->search) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%");
            });
        }

        $monthlyPayments = $query->orderBy('payment_date', 'desc')->paginate(15)->appends($request->all());

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
            'student_id'     => 'required|exists:students,id',
            'course_id'      => 'required|exists:courses,id',
            'month_number'   => 'required|integer|min:1|max:12',
            'amount'         => 'required|numeric|gt:0',
            'payment_date'   => 'required|date', // Accept any date format
            'payment_method' => 'required|in:cash,card,bank_transfer',
            'notes'          => 'nullable|string|max:200',
        ]);

        $data = $request->only([
            'student_id',
            'course_id',
            'month_number',
            'amount',
            'notes'
        ]);

        // Convert input to Carbon
        $data['payment_date'] = Carbon::parse($request->payment_date);
        $data['recorded_by'] = Auth::id();

        MonthlyPayment::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Monthly payment added successfully.'
        ]);
    }

    // ======================================================
    // ✅ QR FIX
    // ======================================================
    public function getStudent(Request $request)
    {
        if ($request->hasFile('qr_image')) {
            $request->validate([
                'qr_image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
            ]);

            $reader = new QrReader($request->file('qr_image')->getPathname());
            $qrRaw = $reader->text();

            if (!$qrRaw) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to read QR code from image.'
                ]);
            }

        } else {
            $request->validate([
                'code' => 'required|string'
            ]);

            $qrRaw = $request->code;
        }

        $qrRaw = trim($qrRaw);
        $qrRaw = str_replace(["\n", "\r", " "], '', $qrRaw);
        $qrCode = strtoupper(pathinfo($qrRaw, PATHINFO_FILENAME));

        $student = Student::with(['course', 'center'])
            ->whereRaw('UPPER(TRIM(qr_code)) = ?', [$qrCode])
            ->orWhereRaw('UPPER(TRIM(qr_code_path)) LIKE ?', ["%{$qrCode}%"])
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

    public function edit(MonthlyPayment $payment)
    {
        $courses = Course::all();
        $payment_date_formatted = Carbon::parse($payment->payment_date)->format('Y-m-d\TH:i');

        return view('reception.payments.edit', compact(
            'payment',
            'courses',
            'payment_date_formatted'
        ));
    }

    public function update(Request $request, MonthlyPayment $payment)
    {
        $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'month_number' => 'required|integer|min:1|max:12',
            'amount'       => 'required|numeric|gt:0',
            'notes'        => 'nullable|string|max:200',
        ]);

        $payment->update([
            'course_id'    => $request->course_id,
            'month_number' => $request->month_number,
            'amount'       => $request->amount,
            'notes'        => $request->notes,
        ]);

        return redirect()
            ->route('reception.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(MonthlyPayment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('reception.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    public function paymentPopup(Student $student)
    {
        return view('reception.payments.popup', compact('student'));
    }
}
