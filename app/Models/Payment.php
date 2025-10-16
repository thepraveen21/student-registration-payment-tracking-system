<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount',
        'payment_date',
        'payment_method',
        'receipt_number',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // Get payment method display name
    public function getPaymentMethodDisplayAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->payment_method));
    }

    // Generate receipt number if not provided
    public static function generateReceiptNumber()
    {
        $prefix = 'RCP-' . date('Ymd') . '-';
        $lastReceipt = self::where('receipt_number', 'like', $prefix . '%')
                          ->orderBy('id', 'desc')
                          ->first();
        
        if ($lastReceipt) {
            $lastNumber = intval(substr($lastReceipt->receipt_number, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

}
