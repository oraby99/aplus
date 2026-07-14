<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_group') || $user->hasRole('super_admin') || $user->type === 'student' || $user->type === 'teacher';
    }

    public function view(User $user, $model = null): bool
    {
        return $user->hasPermissionTo('view_group') || $user->hasRole('super_admin') || $user->type === 'student' || $user->type === 'teacher';
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_group') || $user->hasRole('super_admin');
    }

    public function update(User $user, $model = null): bool
    {
        if ($user->hasPermissionTo('update_group') || $user->hasRole('super_admin')) {
            return true;
        }
        
        return $user->type === 'teacher' && $model && $model->teacher_id === $user->id;
    }

    public function delete(User $user, $model = null): bool
    {
        return $user->hasPermissionTo('delete_group') || $user->hasRole('super_admin');
    }
}