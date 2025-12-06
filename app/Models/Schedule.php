<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'time',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'string',
    ];
}

