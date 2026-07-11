<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;

class GroupPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function view(User $user, Group $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->teacher_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function update(User $user, Group $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->teacher_id === $user->id;
    }

    public function delete(User $user, Group $model): bool
    {
        return $user->type === 'admin';
    }
}
