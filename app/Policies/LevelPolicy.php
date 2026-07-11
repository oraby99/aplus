<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Level;

class LevelPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function view(User $user, Level $model): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function create(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function update(User $user, Level $model): bool
    {
        return $user->type === 'admin';
    }

    public function delete(User $user, Level $model): bool
    {
        return $user->type === 'admin';
    }
}
