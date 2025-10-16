<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'type',
        'message',
        'delivery_method',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Get type display name
    public function getTypeDisplayAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }

    // Scope for unread notifications
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope for specific type
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
