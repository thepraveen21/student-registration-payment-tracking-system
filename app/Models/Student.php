<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'registration_number',
        'first_name',
        'last_name',
        'email',
        'student_phone',
        'parent_phone',
        'date_of_birth',
        'address',
        'qr_code_path',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
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

    /**
     * Get the full URL for the student's QR code
     */
    public function getQrCodeUrlAttribute()
    {
        if ($this->qr_code_path) {
            return asset('storage/' . $this->qr_code_path);
        }
        return null;
    }

    /**
     * Get the full name of the student
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


}
