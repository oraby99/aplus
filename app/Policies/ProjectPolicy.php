<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function view(User $user, Project $model): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function create(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function update(User $user, Project $model): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function delete(User $user, Project $model): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }
}
