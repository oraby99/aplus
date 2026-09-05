<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HomeworkPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        // Students manage homework inside their classroom, not via admin dashboard tables
        if ($user->type === 'student') {
            return false;
        }

        return $user->hasRole('super_admin') || $user->type === 'admin' || $user->type === 'teacher';
    }

    public function view(User $user, $model = null): bool
    {
        if ($user->type === 'student') {
            return $model && $model->student_id === $user->id;
        }

        return $user->hasRole('super_admin') || $user->type === 'admin' || $user->type === 'teacher';
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin') || $user->type === 'admin' || $user->type === 'teacher';
    }

    public function update(User $user, $model = null): bool
    {
        return $user->hasRole('super_admin') || $user->type === 'admin' || $user->type === 'teacher';
    }

    public function delete(User $user, $model = null): bool
    {
        return $user->hasRole('super_admin') || $user->type === 'admin';
    }
}
