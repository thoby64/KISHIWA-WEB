<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function view(User $user, ClassModel $class)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function create(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function update(User $user, ClassModel $class)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function delete(User $user, ClassModel $class)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function manage_classes(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }
}