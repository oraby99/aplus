<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AcademyInfo;

class AcademyInfoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function view(User $user, AcademyInfo $model): bool
    {
        return $user->type === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function update(User $user, AcademyInfo $model): bool
    {
        return $user->type === 'admin';
    }

    public function delete(User $user, AcademyInfo $model): bool
    {
        return $user->type === 'admin';
    }
}
