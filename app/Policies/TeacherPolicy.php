<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function view(User $user, Teacher $teacher)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function create(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function update(User $user, Teacher $teacher)
    {
        return ($user->role === 'admin' || $user->role === 'manager') && 
               ($user->id === $teacher->created_by || $user->role === 'admin');
    }

    public function delete(User $user, Teacher $teacher)
    {
        return ($user->role === 'admin' || $user->role === 'manager') && 
               ($user->id === $teacher->created_by || $user->role === 'admin');
    }

    public function manage_teachers(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }
}