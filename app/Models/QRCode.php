<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
    protected $table = 'qr_codes';
    
    protected $fillable = [
        'code',
        'qr_image_path',
        'is_assigned',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
