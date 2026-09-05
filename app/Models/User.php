<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password', 'type', 'phone', 'is_active', 'total_sessions', 'age', 'parent_name', 'parent_phone', 'school'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->type, ['admin', 'teacher', 'student']) && $this->is_active;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'total_sessions' => 'integer',
        ];
    }

    // ===== Attendance Tracking Methods (24 Sessions System) =====

    public function getTotalSessionsAttribute(): int
    {
        return (int) ($this->attributes['total_sessions'] ?? 24) ?: 24;
    }

    public function getAttendedSessionsCountAttribute(): int
    {
        return $this->attendances()->whereIn('status', ['present', 'late'])->count();
    }

    public function getPresentSessionsCountAttribute(): int
    {
        return $this->attendances()->where('status', 'present')->count();
    }

    public function getLateSessionsCountAttribute(): int
    {
        return $this->attendances()->where('status', 'late')->count();
    }

    public function getAbsentSessionsCountAttribute(): int
    {
        return $this->attendances()->where('status', 'absent')->count();
    }

    public function getRemainingSessionsCountAttribute(): int
    {
        return max(0, $this->total_sessions - $this->attended_sessions_count);
    }

    public function getAttendancePercentageAttribute(): float
    {
        $total = $this->total_sessions;
        if ($total <= 0) return 0;
        return min(100, round(($this->attended_sessions_count / $total) * 100, 1));
    }

    // ===== Student Relationships =====

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'student_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'student_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'student_id');
    }

    public function homeworks(): HasMany
    {
        return $this->hasMany(Homework::class, 'student_id');
    }
}
