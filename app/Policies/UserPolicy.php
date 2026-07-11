<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function view(User $user, User $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        if ($user->type === 'teacher') {
            return $model->type === 'student' || $model->id === $user->id;
        }
        
        return false;
    }

    public function create(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function update(User $user, User $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        // Teachers can only update their own profile info
        return $user->type === 'teacher' && $model->id === $user->id;
    }

    public function delete(User $user, User $model): bool
    {
        // Prevent deleting super admin or current logged in user
        return $user->type === 'admin' && $model->id !== 1 && $model->id !== $user->id;
    }
}
