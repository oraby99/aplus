<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Evaluation;

class EvaluationPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function view(User $user, Evaluation $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->teacher_id === $user->id;
    }

    public function create(User $user): bool
    {
        return in_array($user->type, ['admin', 'teacher']);
    }

    public function update(User $user, Evaluation $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->teacher_id === $user->id;
    }

    public function delete(User $user, Evaluation $model): bool
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        return $user->type === 'teacher' && $model->teacher_id === $user->id;
    }
}
