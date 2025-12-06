<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\QRCode;
use App\Models\Student;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QRGenerator;
use Illuminate\Support\Facades\Storage;

class QRCodeController extends Controller
{
    /**
     * Display QR code management page
     */
    public function manage()
    {
        $students = Student::orderBy('first_name')->get();
        $unassignedQRCodes = QRCode::whereNull('student_id')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('reception.qrcodes.manage', compact(
            'students',
            'unassignedQRCodes'
        ));
    }

    /**
     * Generate a new batch of QR codes
     */
    public function generate(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:1|max:100'
        ]);

        $count = $request->input('count');
        $generated = 0;

        for ($i = 0; $i < $count; $i++) {

            // Get last QR code
            $last = QRCode::orderBy('id', 'desc')->first();
            $nextNumber = $last ? $last->id + 1 : 1;

            // Format: QR00001
            $code = 'QR' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Generate QR image
            $qrCodeUrl = route('qr.show', $code);
            $qrCodeImage = QRGenerator::format('svg')->size(200)->generate($qrCodeUrl);
            $fileName = 'qrcode_' . $code . '_' . time() . '.svg';
            $qrCodePath = 'qrcodes/' . $fileName;

            // Create directory if missing
            $qrCodeDirectory = public_path('qrcodes');
            if (!file_exists($qrCodeDirectory)) {
                mkdir($qrCodeDirectory, 0755, true);
            }

            file_put_contents(public_path($qrCodePath), $qrCodeImage);

            // Save to DB
            QRCode::create([
                'code' => $code,
                'qr_image_path' => $qrCodePath,
                'is_assigned' => false,
            ]);

            $generated++;
        }

        return redirect()->back()->with('success', "{$generated} new QR codes have been generated.");
    }

    /**
     * Display batch printing interface
     */
    public function printBatch()
    {
        $unassignedCodes = QRCode::whereNull('student_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reception.qrcodes.print-batch', compact('unassignedCodes'));
    }

    /**
     * Print a single student's QR code
     */
    public function printSingle(Student $student)
    {
        if (!$student->qrCode) {
            return redirect()->back()->with('error', 'No QR code assigned to this student.');
        }

        return view('reception.qrcodes.print-single', compact('student'));
    }

    /**
     * Assign QR code to a student
     */
    public function assign(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'student_id' => 'required|exists:students,id'
        ]);

        $scannedCode = $request->input('qr_code');
        // Normalize scanned code — allow full URL or path and extract last segment
        if ($scannedCode) {
            $scannedCode = trim($scannedCode);
            if (strpos($scannedCode, '/') !== false) {
                $parts = explode('/', rtrim($scannedCode, '/'));
                $scannedCode = end($parts);
            }
        }
        $student = Student::findOrFail($request->student_id);

        // Find the QR code record
        $qrCode = QRCode::where('code', $scannedCode)->first();

        if (!$qrCode) {
            return redirect()->back()->with('error', 'Scanned QR code not found in the system.');
        }

        // Check if the QR code is already assigned
        if ($qrCode->student_id && $qrCode->student_id != $student->id) {
            return redirect()->back()->with('error', 'This QR code is already assigned to another student.');
        }

        // Check if the student already has a QR code
        if ($student->qrCode && $student->qrCode->id != $qrCode->id) {
            return redirect()->back()->with('error', 'This student already has a different QR code assigned. Please unassign it first.');
        }

        // Assign the QR code to the student
        $qrCode->student_id = $student->id;
        $qrCode->is_assigned = true;
        $qrCode->save();

        // Update the student's qr_code_path
        $student->qr_code_path = $qrCode->qr_image_path;
        $student->save();

        return redirect()->back()->with('success', 'QR code successfully assigned to student.');
    }

    /**
     * Unassign QR code from a student
     */
    public function unassign(QRCode $qrCode)
    {
        if (!$qrCode->student_id) {
            return redirect()->back()->with('error', 'This QR code is not assigned to any student.');
        }

        $qrCode->update(['student_id' => null, 'is_assigned' => false]);

        // Also remove the qr_code_path from the student
        if ($qrCode->student) {
            $qrCode->student->qr_code_path = null;
            $qrCode->student->save();
        }

        return redirect()->back()->with('success', 'QR code successfully unassigned.');
    }
}