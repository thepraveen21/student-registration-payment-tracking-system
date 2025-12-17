<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'center_id', // Add center_id to fillable
        'registration_number',
        'first_name',
        'last_name',
        'email',
        'student_phone',
        'parent_phone',
        'date_of_birth',
        'address',
        'status',
        'qr_code_path', 
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentSchedules()
    {
        return $this->hasMany(PaymentSchedule::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function qrCode()
    {
        return $this->hasOne(QRCode::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function monthlyPayments()
    {
        return $this->hasMany(MonthlyPayment::class);
    }

    /**
     * ✅ Accessor: Get the full URL of the QR code image
     */
    public function getQrCodeUrlAttribute()
    {
        if ($this->qr_code_path) {
            return asset($this->qr_code_path);
        }
        return null;
    }

    /**
     * ✅ Virtual attribute to simulate test project's "qr_code" field
     * (Returns the value embedded in the QR — your registration number)
     */
    // public function getQrCodeAttribute()
    // {
    //     return $this->registration_number;
    // }

    /**
     * Get the full name of the student.
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function index()
    {
        $students = Student::with('course')->paginate(10);
        return view('students.index', compact('students'));
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Generate a new unique registration number.
     * Pattern: prefix + zero-padded number (default prefix 'REG-').
     */
    public static function generateRegistrationNumber($prefix = 'REG-')
    {
        $rows = DB::table('students')
            ->where('registration_number', 'like', $prefix . '%')
            ->pluck('registration_number');

        $max = 0;
        foreach ($rows as $r) {
            if (preg_match('/(\d+)$/', $r, $m)) {
                $num = (int) $m[1];
                if ($num > $max) $max = $num;
            }
        }

        $next = $max + 1;
        $number = str_pad($next, 4, '0', STR_PAD_LEFT);

        return $prefix . $number;
    }

    /**
     * Get the payment status of the student.
     */
    public function getPaymentStatusAttribute()
    {
        $totalDue = $this->paymentSchedules()->sum('amount_due');
        $totalPaid = $this->paymentSchedules()->sum('amount_paid');

        if ($totalDue == 0) {
            return 'No Schedule';
        }

        if ($totalPaid >= $totalDue) {
            return 'Paid';
        }

        return 'Pending';
    }

    /**
     * Return the assigned QR value for the student.
     * - Prefer the qr_codes.code value if a QRCode relation exists.
     * - Fallback to parsing the code from the QR image filename (qrcode_{code}_{timestamp}.svg).
     */
    public function getQrValueAttribute()
    {
        // Prefer the explicit QRCode->code from the relation
        $qc = $this->getRelationValue('qrCode');
        if (! $qc) {
            $qc = $this->qrCode()->first();
        }

        if ($qc && $qc->code) {
            return $qc->code;
        }

        // If there's a qr_code_path filled, try to parse it
        if ($this->qr_code_path) {
            $file = basename($this->qr_code_path);

            // Patterns such as qrcode_QR0005_1698889999.svg or qrcode_REG-0001_1698889.svg
            if (preg_match('/qrcode_(.*?)_\d+\.svg$/', $file, $m)) {
                return $m[1];
            }

            // Pattern without timestamp: qrcode_QR0005.svg
            if (preg_match('/qrcode_(.*?)\.svg$/', $file, $m2)) {
                return $m2[1];
            }
        }

        return null;
    }


}
