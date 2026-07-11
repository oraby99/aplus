<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attendance;

class AttendancePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function view(User $user, Attendance $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->classSession?->group?->teacher_id === $user->id;
    }

    public function create(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function update(User $user, Attendance $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->classSession?->group?->teacher_id === $user->id;
    }

    public function delete(User $user, Attendance $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->classSession?->group?->teacher_id === $user->id;
    }
}
