<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClassSession;

class ClassSessionPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function view(User $user, ClassSession $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->group?->teacher_id === $user->id;
    }

    public function create(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function update(User $user, ClassSession $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->group?->teacher_id === $user->id;
    }

    public function delete(User $user, ClassSession $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->group?->teacher_id === $user->id;
    }
}
