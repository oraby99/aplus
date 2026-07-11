<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Payment;

class PaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function view(User $user, Payment $model): bool
    {
        return $user->type === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function update(User $user, Payment $model): bool
    {
        return $user->type === 'admin';
    }

    public function delete(User $user, Payment $model): bool
    {
        return $user->type === 'admin';
    }
}
