<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Certificate;

class CertificatePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function view(User $user, Certificate $model): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function create(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function update(User $user, Certificate $model): bool
    {
        return $user->type === 'admin';
    }

    public function delete(User $user, Certificate $model): bool
    {
        return $user->type === 'admin';
    }
}
