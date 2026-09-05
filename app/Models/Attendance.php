<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $guarded = [];

    public function classSession(): BelongsTo
    {
        return $this->belongsTo(ClassSession::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    protected static function booted(): void
    {
        static::saving(function (Attendance $attendance) {
            if (empty($attendance->group_id) && !empty($attendance->class_session_id)) {
                $attendance->group_id = $attendance->classSession?->group_id;
            }
        });
    }
}
