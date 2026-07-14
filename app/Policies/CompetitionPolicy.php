<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompetitionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_competition') || $user->hasRole('super_admin');
    }

    public function view(User $user, $model = null): bool
    {
        return $user->hasPermissionTo('view_competition') || $user->hasRole('super_admin');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_competition') || $user->hasRole('super_admin');
    }

    public function update(User $user, $model = null): bool
    {
        return $user->hasPermissionTo('update_competition') || $user->hasRole('super_admin');
    }

    public function delete(User $user, $model = null): bool
    {
        return $user->hasPermissionTo('delete_competition') || $user->hasRole('super_admin');
    }
}