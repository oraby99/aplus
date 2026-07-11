<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course_name',
        'score',
        'feedback',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];
}
