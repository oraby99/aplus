<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Testimonial;

class TestimonialPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function view(User $user, Testimonial $model): bool
    {
        return $user->type === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function update(User $user, Testimonial $model): bool
    {
        return $user->type === 'admin';
    }

    public function delete(User $user, Testimonial $model): bool
    {
        return $user->type === 'admin';
    }
}
