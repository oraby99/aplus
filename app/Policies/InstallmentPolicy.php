<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Installment;

class InstallmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function view(User $user, Installment $model): bool
    {
        return $user->type === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function update(User $user, Installment $model): bool
    {
        return $user->type === 'admin';
    }

    public function delete(User $user, Installment $model): bool
    {
        return $user->type === 'admin';
    }
}
