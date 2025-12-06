<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QRCode;
use App\Models\Attendance;
use Carbon\Carbon;

class QRController extends Controller
{
    /**
     * Verify student identity from QR code.
     */
    public function verify($code)
    {
        $qrCode = QRCode::with(['student' => function($query) {
            $query->with('course');
        }])->where('code', $code)->first();

        if (!$qrCode) {
            abort(404, 'Invalid QR code');
        }

        if (!$qrCode->student) {
            abort(404, 'QR code is not assigned to any student');
        }

        return view('qr.verify', [
            'student' => $qrCode->student,
            'qrCode' => $qrCode
        ]);
    }

    /**
     * Display student details for a scanned QR code.
     * Automatically marks attendance if not already marked today.
     */
    public function show($code)
{
    $qr = QRCode::with('student.payments','student.attendances')->where('code', $code)->first();

    if (! $qr) {
        abort(404, 'QR code not found');
    }

    $student = $qr->student;

    $attendanceMessage = null;

    if ($student) {
        // Check if attendance already marked today
        $todayAttendance = $student->attendances()
            ->whereDate('attended_at', now()->toDateString())
            ->first();

        if (!$todayAttendance) {
            // Mark attendance automatically
            $todayAttendance = Attendance::create([
                'student_id' => $student->id,
                'attended_at' => now(),
                'status' => 'present',
                'notes' => 'Marked automatically via QR scan',
            ]);
            $attendanceMessage = "Attendance marked automatically.";
        } else {
            $attendanceMessage = "Attendance already marked today.";
        }

        $payments = $student->payments()->orderBy('payment_date','desc')->get();
        $totalPaid = $payments->sum('amount');
        $latestAttendance = $student->attendances()->latest('attended_at')->first();

        return view('qr.show', compact(
            'qr',
            'student',
            'payments',
            'totalPaid',
            'latestAttendance',
            'attendanceMessage'
        ));
    }

    return view('qr.show', [
        'qr' => $qr,
        'student' => null,
        'attendanceMessage' => 'QR code not assigned to any student'
    ]);

    }


    /**
     * Mark attendance manually (for forms, if needed).
     */
    public function storeAttendance(Request $request, $code)
    {
        $qr = QRCode::with('student')->where('code', $code)->firstOrFail();

        $student = $qr->student;
        if (! $student) {
            return redirect()->back()->with('error', 'QR code is not assigned to any student');
        }

        $status = $request->input('status', 'present');

        Attendance::create([
            'student_id' => $student->id,
            'attended_at' => now(),
            'status' => $status,
            'notes' => $request->input('notes'),
        ]);

        return redirect()->back()->with('success', 'Attendance recorded');
    }

    /**
     * Show test page with all QR codes
     */
    public function test()
    {
        $qrcodes = QRCode::with('student')->orderBy('code')->paginate(15);
        return view('qr.test', compact('qrcodes'));
    }

    /**
 * Mark attendance automatically when scanned from dashboard.
 */
    public function storeAttendanceFromScanner($code)
    {
        $qr = QRCode::with('student')->where('code', $code)->first();

        if (! $qr || ! $qr->student) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or unassigned QR code'
            ]);
        }

        $student = $qr->student;

        // Check if attendance is already marked today
        $alreadyMarked = $student->attendances()
            ->whereDate('attended_at', now()->toDateString())
            ->exists();

        if ($alreadyMarked) {
            return response()->json([
                'status' => 'info',
                'message' => 'Attendance already marked today for ' . $student->name
            ]);
        }

        // Mark attendance
        Attendance::create([
            'student_id' => $student->id,
            'attended_at' => now(),
            'status' => 'present',
            'notes' => 'Scanned via reception dashboard QR'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Attendance marked for ' . $student->name
        ]);

    }

}
