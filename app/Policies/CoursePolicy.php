<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function view(User $user, Course $model): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function create(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function update(User $user, Course $model): bool
    {
        return $user->type === 'admin';
    }

    public function delete(User $user, Course $model): bool
    {
        return $user->type === 'admin';
    }
}
